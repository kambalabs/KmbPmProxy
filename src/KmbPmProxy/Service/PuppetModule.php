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
use KmbPmProxy\Options\PuppetModuleServiceOptionsInterface;
use KmbPmProxy;
use Zend\Stdlib\Hydrator\HydratorInterface;

class PuppetModule implements PuppetModuleInterface
{
    /** @var ClientInterface */
    protected $pmProxyClient;

    /** @var PuppetModuleServiceOptionsInterface */
    protected $options;

    /** @var HydratorInterface */
    protected $moduleHydrator;

    /** @var HydratorInterface */
    protected $classHydrator;

    /**
     * @param Model\EnvironmentInterface $environment
     * @return KmbPmProxy\Model\PuppetModule[]
     */
    public function getAllByEnvironment(Model\EnvironmentInterface $environment)
    {
        $modules = [];
        $result = $this->pmProxyClient->get('/environments/' . $environment->getId() . '/modules');
        foreach ($result as $moduleData) {
            $moduleEntityClassName = $this->getOptions()->getPuppetModuleEntityClass();
            /** @var \KmbPmProxy\Model\PuppetModule $module */
            $module = new $moduleEntityClassName();
            $this->getModuleHydrator()->hydrate((array)$moduleData, $module);
            $classes = [];
            foreach ($moduleData->classes as $classData) {
                $classEntityClassName = $this->getOptions()->getPuppetClassEntityClass();
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
     * @return KmbPmProxy\Model\PuppetModule
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
     * @return PuppetModule
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
     * @param \KmbPmProxy\Options\PuppetModuleServiceOptionsInterface $options
     * @return PuppetModule
     */
    public function setOptions($options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * Get Options.
     *
     * @return \KmbPmProxy\Options\PuppetModuleServiceOptionsInterface
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Set ModuleHydrator.
     *
     * @param \Zend\Stdlib\Hydrator\HydratorInterface $moduleHydrator
     * @return PuppetModule
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
            $moduleHydratorClass = $this->getOptions()->getPuppetModuleHydratorClass();
            $this->moduleHydrator = new $moduleHydratorClass;
        }
        return $this->moduleHydrator;
    }

    /**
     * Set ClassHydrator.
     *
     * @param \Zend\Stdlib\Hydrator\HydratorInterface $classHydrator
     * @return PuppetModule
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
            $classHydratorClass = $this->getOptions()->getPuppetClassHydratorClass();
            $this->classHydrator = new $classHydratorClass;
        }
        return $this->classHydrator;
    }
}