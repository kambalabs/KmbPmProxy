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

use KmbPmProxy\Model\PuppetModule;
use Zend\Stdlib\Hydrator\HydratorInterface;

class PuppetModuleHydrator implements HydratorInterface
{
    /**
     * Extract values from an object
     *
     * @param  PuppetModule $object
     * @return array
     */
    public function extract($object)
    {
    }

    /**
     * Hydrate $object with the provided $data.
     *
     * @param  array  $data
     * @param  PuppetModule $object
     * @return PuppetModule
     */
    public function hydrate(array $data, $object)
    {
        if (isset($data['name'])) {
            $object->setName($data['name']);
        }
        if (isset($data['version'])) {
            $object->setVersion($data['version']);
        }
        if (isset($data['source'])) {
            $object->setSource($data['source']);
        }
        if (isset($data['project_page'])) {
            $object->setProjectPage($data['project_page']);
        }
        if (isset($data['issues_url'])) {
            $object->setIssuesUrl($data['issues_url']);
        }
        if (isset($data['author'])) {
            $object->setAuthor($data['author']);
        }
        if (isset($data['summary'])) {
            $object->setSummary($data['summary']);
        }
        if (isset($data['license'])) {
            $object->setLicense($data['license']);
        }
        return $object;
    }
}
