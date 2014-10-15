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

class ModuleOptions extends AbstractOptions implements ClientOptionsInterface, PuppetModuleServiceOptionsInterface
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
    protected $puppetModuleEntityClass = 'KmbPmProxy\Model\PuppetModule';

    /**
     * @var string
     */
    protected $puppetClassEntityClass = 'KmbPmProxy\Model\PuppetClass';

    /**
     * @var string
     */
    protected $puppetModuleHydratorClass = 'KmbPmProxy\Model\PuppetModuleHydrator';

    /**
     * @var string
     */
    protected $puppetClassHydratorClass = 'KmbPmProxy\Model\PuppetClassHydrator';

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
     * Set puppet module entity class name.
     *
     * @param string $puppetModuleEntityClass
     * @return PuppetModuleServiceOptionsInterface
     */
    public function setPuppetModuleEntityClass($puppetModuleEntityClass)
    {
        $this->puppetModuleEntityClass = $puppetModuleEntityClass;
        return $this;
    }

    /**
     * Get puppet module entity class name.
     *
     * @return string
     */
    public function getPuppetModuleEntityClass()
    {
        return $this->puppetModuleEntityClass;
    }

    /**
     * Set puppet module hydrator class name.
     *
     * @param string $puppetModuleHydratorClass
     * @return PuppetModuleServiceOptionsInterface
     */
    public function setPuppetModuleHydratorClass($puppetModuleHydratorClass)
    {
        $this->puppetModuleHydratorClass = $puppetModuleHydratorClass;
        return $this;
    }

    /**
     * Get puppet module hydrator class name.
     *
     * @return string
     */
    public function getPuppetModuleHydratorClass()
    {
        return $this->puppetModuleHydratorClass;
    }

    /**
     * Set puppet class entity class name.
     *
     * @param string $puppetClassEntityClass
     * @return PuppetModuleServiceOptionsInterface
     */
    public function setPuppetClassEntityClass($puppetClassEntityClass)
    {
        $this->puppetClassEntityClass = $puppetClassEntityClass;
        return $this;
    }

    /**
     * Get puppet class entity class name.
     *
     * @return string
     */
    public function getPuppetClassEntityClass()
    {
        return $this->puppetClassEntityClass;
    }

    /**
     * Set puppet class hydrator class name.
     *
     * @param string $puppetClassHydratorClass
     * @return PuppetModuleServiceOptionsInterface
     */
    public function setPuppetClassHydratorClass($puppetClassHydratorClass)
    {
        $this->puppetClassHydratorClass = $puppetClassHydratorClass;
        return $this;
    }

    /**
     * Get puppet class hydrator class name.
     *
     * @return string
     */
    public function getPuppetClassHydratorClass()
    {
        return $this->puppetClassHydratorClass;
    }
}
