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

interface PuppetModuleServiceOptionsInterface
{

    /**
     * Set puppet module entity class name.
     *
     * @param string $puppetModuleEntityClass
     * @return PuppetModuleServiceOptionsInterface
     */
    public function setPuppetModuleEntityClass($puppetModuleEntityClass);

    /**
     * Get puppet module entity class name.
     *
     * @return string
     */
    public function getPuppetModuleEntityClass();

    /**
     * Set puppet module hydrator class name.
     *
     * @param string $puppetModuleHydratorClass
     * @return PuppetModuleServiceOptionsInterface
     */
    public function setPuppetModuleHydratorClass($puppetModuleHydratorClass);

    /**
     * Get puppet module hydrator class name.
     *
     * @return string
     */
    public function getPuppetModuleHydratorClass();

    /**
     * Set puppet class entity class name.
     *
     * @param string $puppetClassEntityClass
     * @return PuppetModuleServiceOptionsInterface
     */
    public function setPuppetClassEntityClass($puppetClassEntityClass);

    /**
     * Get puppet class entity class name.
     *
     * @return string
     */
    public function getPuppetClassEntityClass();

    /**
     * Set puppet class hydrator class name.
     *
     * @param string $puppetClassHydratorClass
     * @return PuppetModuleServiceOptionsInterface
     */
    public function setPuppetClassHydratorClass($puppetClassHydratorClass);

    /**
     * Get puppet class hydrator class name.
     *
     * @return string
     */
    public function getPuppetClassHydratorClass();
}
