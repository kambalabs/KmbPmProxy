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

use KmbDomain\Model\GroupClass;
use KmbDomain\Model\GroupClassInterface;

class GroupClassHydrator implements GroupClassHydratorInterface
{
    /** @var  GroupParameterHydratorInterface */
    protected $groupParameterHydrator;

    /**
     * Hydrate $class with the provided $templates.
     *
     * @param  \stdClass[]         $templates
     * @param  GroupClassInterface $class
     * @return GroupClass
     */
    public function hydrate($templates, $class)
    {
        if (is_array($templates) && !empty($templates)) {
            $availableParameters = array_filter($templates, function ($template) use ($class) {
                return !$class->hasParameterWithName($template->name);
            });
            if (!empty($availableParameters)) {
                $class->setAvailableParameters(array_values($availableParameters));
            }
            foreach ($templates as $template) {
                $parameter = $class->getParameterByName($template->name);
                if ($parameter != null) {
                    $this->groupParameterHydrator->hydrate($template, $parameter);
                }
            }
        }
    }

    /**
     * Set GroupParameterHydrator.
     *
     * @param GroupParameterHydratorInterface $groupParameterHydrator
     * @return GroupClassHydrator
     */
    public function setGroupParameterHydrator($groupParameterHydrator)
    {
        $this->groupParameterHydrator = $groupParameterHydrator;
        return $this;
    }

    /**
     * Get GroupParameterHydrator.
     *
     * @return GroupParameterHydratorInterface
     */
    public function getGroupParameterHydrator()
    {
        return $this->groupParameterHydrator;
    }
}
