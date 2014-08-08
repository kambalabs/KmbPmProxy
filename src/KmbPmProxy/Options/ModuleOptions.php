<?php
/**
 * @copyright Copyright (c) 2014 Orange Applications for Business
 * @link      http://github.com/multimediabs/kamba for the canonical source repository
 *
 * This file is part of kamba.
 *
 * kamba is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 *
 * kamba is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with kamba.  If not, see <http://www.gnu.org/licenses/>.
 */
namespace KmbPmProxy\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions implements ClientOptionsInterface, ModuleServiceOptionsInterface
{
    /**
     * Turn off strict options mode
     */
    protected $__strictMode__ = false;

    /**
     * @var string
     */
    protected $baseUri = 'http://localhost:3000';

    /**
     * @var array
     */
    protected $httpOptions = [];

    /**
     * @var string
     */
    protected $moduleEntityClass = 'KmbPmProxy\Model\Module';

    /**
     * @var string
     */
    protected $classEntityClass = 'KmbPmProxy\Model\PuppetClass';

    /**
     * @var string
     */
    protected $moduleHydratorClass = 'KmbPmProxy\Model\ModuleHydrator';

    /**
     * @var string
     */
    protected $classHydratorClass = 'KmbPmProxy\Model\PuppetClassHydrator';

    /**
     * Set PmProxy base URI.
     *
     * @param string $baseUri
     * @return ClientOptionsInterface
     */
    public function setBaseUri($baseUri)
    {
        $this->baseUri = $baseUri;
        return $this;
    }

    /**
     * Get PmProxy base URI.
     *
     * @return string
     */
    public function getBaseUri()
    {
        return $this->baseUri;
    }

    /**
     * Set HTTP client options.
     *
     * @param $httpOptions
     *
     * @return ClientOptionsInterface
     */
    public function setHttpOptions($httpOptions)
    {
        $this->httpOptions = $httpOptions;
        return $this;
    }

    /**
     * Get HTTP client options.
     *
     * @return array
     */
    public function getHttpOptions()
    {
        return $this->httpOptions;
    }

    /**
     * Set module entity class name.
     *
     * @param string $moduleEntityClass
     * @return ModuleServiceOptionsInterface
     */
    public function setModuleEntityClass($moduleEntityClass)
    {
        $this->moduleEntityClass = $moduleEntityClass;
        return $this;
    }

    /**
     * Get module entity class name.
     *
     * @return string
     */
    public function getModuleEntityClass()
    {
        return $this->moduleEntityClass;
    }

    /**
     * Set module hydrator class name.
     *
     * @param string $moduleHydratorClass
     * @return ModuleServiceOptionsInterface
     */
    public function setModuleHydratorClass($moduleHydratorClass)
    {
        $this->moduleHydratorClass = $moduleHydratorClass;
        return $this;
    }

    /**
     * Get module hydrator class name.
     *
     * @return string
     */
    public function getModuleHydratorClass()
    {
        return $this->moduleHydratorClass;
    }

    /**
     * Set class entity class name.
     *
     * @param string $classEntityClass
     * @return ModuleServiceOptionsInterface
     */
    public function setClassEntityClass($classEntityClass)
    {
        $this->classEntityClass = $classEntityClass;
        return $this;
    }

    /**
     * Get class entity class name.
     *
     * @return string
     */
    public function getClassEntityClass()
    {
        return $this->classEntityClass;
    }

    /**
     * Set class hydrator class name.
     *
     * @param string $classHydratorClass
     * @return ModuleServiceOptionsInterface
     */
    public function setClassHydratorClass($classHydratorClass)
    {
        $this->classHydratorClass = $classHydratorClass;
        return $this;
    }

    /**
     * Get class hydrator class name.
     *
     * @return string
     */
    public function getClassHydratorClass()
    {
        return $this->classHydratorClass;
    }
}
