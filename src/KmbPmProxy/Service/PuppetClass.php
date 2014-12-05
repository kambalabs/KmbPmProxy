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
namespace KmbPmProxy\Service;

use KmbDomain\Model;
use KmbDomain;
use KmbPmProxy;

class PuppetClass implements PuppetClassInterface
{
    /** @var KmbPmProxy\Service\PuppetModule */
    protected $moduleService;

    /** @var  array */
    protected $classes = [];

    /**
     * @param KmbDomain\Model\EnvironmentInterface $environment
     * @param string                               $name
     * @return KmbPmProxy\Model\PuppetClass
     */
    public function getByEnvironmentAndName(KmbDomain\Model\EnvironmentInterface $environment, $name)
    {
        $classes = $this->getAllClasses($environment);
        return isset($classes[$name]) ? $classes[$name] : null;
    }

    protected function getAllClasses(KmbDomain\Model\EnvironmentInterface $environment)
    {
        $envKey = $environment->getNormalizedName();
        if (!isset($this->classes[$envKey])) {
            $modules = $this->moduleService->getAllInstalledByEnvironment($environment);
            $this->classes[$envKey] = [];
            foreach ($modules as $module) {
                if ($module->hasClasses()) {
                    foreach ($module->getClasses() as $class) {
                        $this->classes[$envKey][$class->getName()] = $class;
                    }
                }
            }
        }
        return $this->classes[$envKey];
    }

    /**
     * Set ModuleService.
     *
     * @param \KmbPmProxy\Service\PuppetModule $moduleService
     * @return PuppetClass
     */
    public function setModuleService($moduleService)
    {
        $this->moduleService = $moduleService;
        return $this;
    }

    /**
     * Get ModuleService.
     *
     * @return \KmbPmProxy\Service\PuppetModule
     */
    public function getModuleService()
    {
        return $this->moduleService;
    }
}
