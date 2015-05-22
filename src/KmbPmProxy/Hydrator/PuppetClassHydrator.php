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

use KmbPmProxy\Model\PuppetClass;
use Zend\Stdlib\Hydrator\HydratorInterface;

class PuppetClassHydrator implements HydratorInterface
{
    /**
     * Extract values from an object
     *
     * @param  PuppetClass $object
     * @return array
     */
    public function extract($object)
    {
    }

    /**
     * Hydrate $object with the provided $data.
     *
     * @param  array  $data
     * @param  PuppetClass $object
     * @return PuppetClass
     */
    public function hydrate(array $data, $object)
    {
        if (isset($data['name'])) {
            $object->setName($data['name']);
        }
        if (isset($data['doc'])) {
            $object->setDocumentation($data['doc']);
        }
        if (isset($data['parameters_definitions']) && is_array($data['parameters_definitions'])) {
            $object->setParametersDefinitions($data['parameters_definitions']);
        }
        if (isset($data['template_definitions']) && is_array($data['template_definitions'])) {
            $object->setParametersTemplates($data['template_definitions']);
        }
        return $object;
    }
}
