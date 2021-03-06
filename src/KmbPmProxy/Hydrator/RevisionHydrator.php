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

use KmbDomain\Model\RevisionInterface;
use KmbPmProxy\Model\PuppetModule;

class RevisionHydrator implements RevisionHydratorInterface
{
    /** @var  GroupHydratorInterface */
    protected $groupHydrator;

    /**
     * Hydrate revision with the provided puppet modules data.
     *
     * @param  PuppetModule[]    $puppetModules
     * @param  RevisionInterface $revision
     * @return RevisionInterface
     */
    public function hydrate($puppetModules, $revision)
    {
        if ($revision->hasGroups()) {
            foreach ($revision->getGroups() as $group) {
                $this->groupHydrator->hydrate($puppetModules, $group);
            }
        }
    }

    /**
     * Set GroupHydrator.
     *
     * @param \KmbPmProxy\Hydrator\GroupHydratorInterface $groupHydrator
     * @return GroupHydrator
     */
    public function setGroupHydrator($groupHydrator)
    {
        $this->groupHydrator = $groupHydrator;
        return $this;
    }

    /**
     * Get GroupHydrator.
     *
     * @return \KmbPmProxy\Hydrator\GroupHydratorInterface
     */
    public function getGroupHydrator()
    {
        return $this->groupHydrator;
    }
}
