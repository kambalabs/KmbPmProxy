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
use KmbPmProxy\ClientInterface;
use KmbPmProxy\Options\ModuleServiceOptionsInterface;
use KmbPmProxy;
use Zend\Stdlib\Hydrator\HydratorInterface;

class Module implements ModuleInterface
{
    /** @var ClientInterface */
    protected $pmProxyClient;

    /** @var ModuleServiceOptionsInterface */
    protected $options;

    /** @var HydratorInterface */
    protected $moduleHydrator;

    /** @var HydratorInterface */
    protected $classHydrator;

    /**
     * @param Model\EnvironmentInterface $environment
     * @return KmbPmProxy\Model\Module[]
     */
    public function getAllByEnvironment(Model\EnvironmentInterface $environment)
    {
        $modules = [];
        $result = $this->pmProxyClient->get('/environments/' . $environment->getId() . '/modules');
        foreach ($result as $moduleData) {
            $moduleEntityClassName = $this->getOptions()->getModuleEntityClass();
            /** @var \KmbPmProxy\Model\Module $module */
            $module = new $moduleEntityClassName();
            $this->getModuleHydrator()->hydrate((array)$moduleData, $module);
            $classes = [];
            foreach ($moduleData->classes as $classData) {
                $classEntityClassName = $this->getOptions()->getClassEntityClass();
                $puppetClass = new $classEntityClassName();
                $classes[] = $this->getClassHydrator()->hydrate((array)$classData, $puppetClass);
            }
            $modules[$module->getName()] = $module->setClasses($classes);
        }
        return $modules;
    }

    /**
     * @param KmbDomain\Model\EnvironmentInterface $environment
     * @param string                               $name
     * @return KmbPmProxy\Model\Module
     */
    public function getByEnvironmentAndName(KmbDomain\Model\EnvironmentInterface $environment, $name)
    {
        $modules = $this->getAllByEnvironment($environment);
        return isset($modules[$name]) ? $modules[$name] : null;
    }

    /**
     * Set PmProxyClient.
     *
     * @param \KmbPmProxy\ClientInterface $pmProxyClient
     * @return Module
     */
    public function setPmProxyClient($pmProxyClient)
    {
        $this->pmProxyClient = $pmProxyClient;
        return $this;
    }

    /**
     * Get PmProxyClient.
     *
     * @return \KmbPmProxy\ClientInterface
     */
    public function getPmProxyClient()
    {
        return $this->pmProxyClient;
    }

    /**
     * Set Options.
     *
     * @param \KmbPmProxy\Options\ModuleServiceOptionsInterface $options
     * @return Module
     */
    public function setOptions($options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * Get Options.
     *
     * @return \KmbPmProxy\Options\ModuleServiceOptionsInterface
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Set ModuleHydrator.
     *
     * @param \Zend\Stdlib\Hydrator\HydratorInterface $moduleHydrator
     * @return Module
     */
    public function setModuleHydrator($moduleHydrator)
    {
        $this->moduleHydrator = $moduleHydrator;
        return $this;
    }

    /**
     * Get ModuleHydrator.
     *
     * @return \Zend\Stdlib\Hydrator\HydratorInterface
     */
    public function getModuleHydrator()
    {
        if ($this->moduleHydrator == null) {
            $moduleHydratorClass = $this->getOptions()->getModuleHydratorClass();
            $this->moduleHydrator = new $moduleHydratorClass;
        }
        return $this->moduleHydrator;
    }

    /**
     * Set ClassHydrator.
     *
     * @param \Zend\Stdlib\Hydrator\HydratorInterface $classHydrator
     * @return Module
     */
    public function setClassHydrator($classHydrator)
    {
        $this->classHydrator = $classHydrator;
        return $this;
    }

    /**
     * Get ClassHydrator.
     *
     * @return \Zend\Stdlib\Hydrator\HydratorInterface
     */
    public function getClassHydrator()
    {
        if ($this->classHydrator == null) {
            $classHydratorClass = $this->getOptions()->getClassHydratorClass();
            $this->classHydrator = new $classHydratorClass;
        }
        return $this->classHydrator;
    }
}
