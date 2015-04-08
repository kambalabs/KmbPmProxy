<?php
/**
 * @copyright Copyright (c) 2014, 2015 Orange Applications for Business
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

use KmbDomain;
use KmbPmProxy\ClientInterface;
use KmbPmProxy;
use KmbPmProxy\Options\PuppetModuleServiceOptionsInterface;
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
     * @return KmbPmProxy\Model\PuppetModule[]
     */
    public function getAllAvailable()
    {
        $moduleEntityClassName = $this->getOptions()->getPuppetModuleEntityClass();
        $modules = [];
        $result = $this->pmProxyClient->get('/modules/available');
        foreach ($result as $moduleName => $versions) {
            /** @var \KmbPmProxy\Model\PuppetModule $module */
            $module = new $moduleEntityClassName;
            $module->setName($moduleName);
            $modules[$moduleName] = $module->setAvailableVersions($versions);
        }
        return $modules;
    }

    /**
     * @param KmbDomain\Model\EnvironmentInterface $environment
     * @return KmbPmProxy\Model\PuppetModule[]
     */
    public function getAllInstallableByEnvironment(KmbDomain\Model\EnvironmentInterface $environment)
    {
        $moduleEntityClassName = $this->getOptions()->getPuppetModuleEntityClass();
        $modules = [];
        $result = $this->pmProxyClient->get('/environments/' . $environment->getNormalizedName() . '/modules/installable');
        foreach ($result as $moduleName => $versions) {
            /** @var \KmbPmProxy\Model\PuppetModule $module */
            $module = new $moduleEntityClassName;
            $module->setName($moduleName);
            $modules[$moduleName] = $module->setAvailableVersions($versions);
        }
        return $modules;
    }

    /**
     * @param KmbDomain\Model\EnvironmentInterface $environment
     * @return KmbPmProxy\Model\PuppetModule[]
     */
    public function getAllInstalledByEnvironment(KmbDomain\Model\EnvironmentInterface $environment)
    {
        $moduleEntityClassName = $this->getOptions()->getPuppetModuleEntityClass();
        $modules = [];
        $result = $this->pmProxyClient->get('/environments/' . $environment->getNormalizedName() . '/modules');
        foreach ($result as $moduleData) {
            /** @var \KmbPmProxy\Model\PuppetModule $module */
            $module = new $moduleEntityClassName;
            $this->getModuleHydrator()->hydrate((array)$moduleData, $module);
            $classes = [];
            foreach ($moduleData->classes as $classData) {
                $classEntityClassName = $this->getOptions()->getPuppetClassEntityClass();
                $puppetClass = new $classEntityClassName;
                $classes[] = $this->getClassHydrator()->hydrate((array)$classData, $puppetClass);
            }
            $modules[$module->getName()] = $module->setClasses($classes);
        }
        return $modules;
    }

    /**
     * @param KmbDomain\Model\EnvironmentInterface $environment
     * @param KmbPmProxy\Model\PuppetModule        $module
     * @param string                               $version
     * @throws KmbPmProxy\Exception\RuntimeException
     */
    public function installInEnvironment(KmbDomain\Model\EnvironmentInterface $environment, KmbPmProxy\Model\PuppetModule $module, $version)
    {
        $options = ['module_version' => $version];
        if ($environment->hasParent()) {
            $options['source'] = $environment->getParent()->getNormalizedName();
        }
        $this->pmProxyClient->put('/environments/' . $environment->getNormalizedName(), $options);
        $this->pmProxyClient->put('/environments/' . $environment->getNormalizedName() . '/modules/' . $module->getName(), $options);
        $this->installInChildren($environment, $module);
    }

    /**
     * @param KmbDomain\Model\EnvironmentInterface $environment
     * @param KmbPmProxy\Model\PuppetModule        $module
     * @param string                               $version
     * @param bool                                 $force
     */
    public function upgradeModuleInEnvironment(KmbDomain\Model\EnvironmentInterface $environment, KmbPmProxy\Model\PuppetModule $module, $version, $force)
    {
        $options = ['module_version' => $version];
        if (isset($force)) {
            $options['force'] = 1;
        }

        $this->pmProxyClient->put('/environments/' . $environment->getNormalizedName(), $environment->hasParent() ? ['source' => $environment->getParent()->getNormalizedName()] : []);
        $this->pmProxyClient->put('/environments/' . $environment->getNormalizedName() . '/modules/' . $module->getName() . '/upgrade', $options);
    }

    /**
     * @param KmbDomain\Model\EnvironmentInterface $environment
     * @param KmbPmProxy\Model\PuppetModule        $module
     */
    public function removeFromEnvironment(KmbDomain\Model\EnvironmentInterface $environment, KmbPmProxy\Model\PuppetModule $module)
    {
        $this->pmProxyClient->delete('/environments/' . $environment->getNormalizedName() . '/modules/' . $module->getName());
        $this->pmProxyClient->put('/environments/' . $environment->getNormalizedName(), $environment->hasParent() ? ['source' => $environment->getParent()->getNormalizedName()] : null);
        $this->removeFromChildren($environment, $module);
    }

    /**
     * @param KmbDomain\Model\EnvironmentInterface $environment
     * @param string                               $name
     * @return KmbPmProxy\Model\PuppetModule
     */
    public function getInstalledByEnvironmentAndName(KmbDomain\Model\EnvironmentInterface $environment, $name)
    {
        $modules = $this->getAllInstalledByEnvironment($environment);
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

    /**
     * @param KmbDomain\Model\EnvironmentInterface $environment
     * @param KmbPmProxy\Model\PuppetModule        $module
     * @return boolean
     */
    protected function isInstalledInEnvironment($environment, $module)
    {
        return $this->getInstalledByEnvironmentAndName($environment, $module->getName()) !== null;
    }

    protected function installInChildren(KmbDomain\Model\EnvironmentInterface $environment, KmbPmProxy\Model\PuppetModule $module)
    {
        if ($environment->hasChildren()) {
            foreach ($environment->getChildren() as $child) {
                if (!$this->isInstalledInEnvironment($child, $module)) {
                    $this->pmProxyClient->put('/environments/' . $child->getNormalizedName(), ['source' => $environment->getNormalizedName()]);
                }
                $this->installInChildren($child, $module);
            }
        }
    }

    protected function removeFromChildren(KmbDomain\Model\EnvironmentInterface $environment, KmbPmProxy\Model\PuppetModule $module)
    {
        if ($environment->hasChildren()) {
            foreach ($environment->getChildren() as $child) {
                $this->pmProxyClient->put('/environments/' . $child->getNormalizedName(), ['source' => $environment->getNormalizedName()]);
                $this->removeFromChildren($child, $module);
            }
        }
    }
}
