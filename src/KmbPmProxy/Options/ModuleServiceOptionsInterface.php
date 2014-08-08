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
namespace KmbPmProxy\Options;

interface ModuleServiceOptionsInterface
{

    /**
     * Set module entity class name.
     *
     * @param string $moduleEntityClass
     * @return ModuleServiceOptionsInterface
     */
    public function setModuleEntityClass($moduleEntityClass);

    /**
     * Get module entity class name.
     *
     * @return string
     */
    public function getModuleEntityClass();

    /**
     * Set module hydrator class name.
     *
     * @param string $moduleHydratorClass
     * @return ModuleServiceOptionsInterface
     */
    public function setModuleHydratorClass($moduleHydratorClass);

    /**
     * Get module hydrator class name.
     *
     * @return string
     */
    public function getModuleHydratorClass();

    /**
     * Set class entity class name.
     *
     * @param string $classEntityClass
     * @return ModuleServiceOptionsInterface
     */
    public function setClassEntityClass($classEntityClass);

    /**
     * Get class entity class name.
     *
     * @return string
     */
    public function getClassEntityClass();

    /**
     * Set class hydrator class name.
     *
     * @param string $classHydratorClass
     * @return ModuleServiceOptionsInterface
     */
    public function setClassHydratorClass($classHydratorClass);

    /**
     * Get class hydrator class name.
     *
     * @return string
     */
    public function getClassHydratorClass();
}
