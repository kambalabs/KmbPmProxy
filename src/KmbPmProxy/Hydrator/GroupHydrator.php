<?php
/**
 * @copyright Copyright (c) 2014 Orange Applications for Business
 * @link      http://github.com/kambalabs for the sources repositories
 *
 * This file is part of Kamba.
 *
 * Kamba is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 *
 * Kamba is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Kamba.  If not, see <http://www.gnu.org/licenses/>.
 */
namespace KmbPmProxy\Hydrator;

use KmbDomain\Model\GroupInterface;
use KmbPmProxy\Model\PuppetModule;

class GroupHydrator implements GroupHydratorInterface
{
    /** @var  GroupClassHydratorInterface */
    protected $groupClassHydrator;

    /**
     * Hydrate group with the provided puppet modules data.
     *
     * @param  PuppetModule[] $puppetModules
     * @param  GroupInterface $group
     * @return GroupInterface
     */
    public function hydrate($puppetModules, $group)
    {
        $availableClasses = [];
        if (!empty($puppetModules)) {
            foreach ($puppetModules as $puppetModule) {
                if ($puppetModule->hasClasses()) {
                    foreach ($puppetModule->getClasses() as $puppetClass) {
                        $groupClass = $group->getClassByName($puppetClass->getName());
                        if ($groupClass != null) {
                            if ($puppetClass->hasParametersTemplates()) {
                                $this->groupClassHydrator->hydrate($puppetClass->getParametersTemplates(), $groupClass);
                            }
                        } else {
                            $availableClasses[$puppetModule->getName()][] = $puppetClass->getName();
                        }
                    }
                }
            }
        }
        return $group->setAvailableClasses($availableClasses);
    }

    /**
     * Set GroupClassHydrator.
     *
     * @param \KmbPmProxy\Hydrator\GroupClassHydratorInterface $groupClassHydrator
     * @return GroupHydrator
     */
    public function setGroupClassHydrator($groupClassHydrator)
    {
        $this->groupClassHydrator = $groupClassHydrator;
        return $this;
    }

    /**
     * Get GroupClassHydrator.
     *
     * @return \KmbPmProxy\Hydrator\GroupClassHydratorInterface
     */
    public function getGroupClassHydrator()
    {
        return $this->groupClassHydrator;
    }
}
