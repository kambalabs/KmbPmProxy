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
namespace KmbPmProxy\Model;

class PuppetClass
{
    /** @var string */
    protected $name;

    /** @var string */
    protected $documentation;

    /** @var \stdClass[] */
    protected $parametersDefinitions;

    /** @var \stdClass[] */
    protected $parametersTemplates;

    public function __construct($name = null, $parametersTemplates = null, $parametersDefinitions = null)
    {
        $this->setName($name);
        $this->setParametersTemplates($parametersTemplates);
        $this->setParametersDefinitions($parametersDefinitions);
    }

    /**
     * Set Name.
     *
     * @param string $name
     * @return PuppetClass
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get Name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set Documentation.
     *
     * @param string $documentation
     * @return PuppetClass
     */
    public function setDocumentation($documentation)
    {
        $this->documentation = $documentation;
        return $this;
    }

    /**
     * Get Documentation.
     *
     * @return string
     */
    public function getDocumentation()
    {
        return $this->documentation;
    }

    /**
     * Set ParametersDefinitions.
     *
     * @param \stdClass[] $parametersDefinitions
     * @return PuppetClass
     */
    public function setParametersDefinitions($parametersDefinitions)
    {
        $this->parametersDefinitions = $parametersDefinitions;
        return $this;
    }

    /**
     * Get ParametersDefinitions.
     *
     * @return \stdClass[]
     */
    public function getParametersDefinitions()
    {
        return $this->parametersDefinitions;
    }

    /**
     * Get specified parameter definition.
     *
     * @param string $name
     * @return \stdClass
     */
    public function getParameterDefinition($name)
    {
        if ($this->hasParametersDefinitions()) {
            foreach ($this->getParametersDefinitions() as $parameterDefinition) {
                if ($parameterDefinition->name === $name) {
                    return $parameterDefinition;
                }
            }
        }
        return null;
    }

    /**
     * @return bool
     */
    public function hasParametersDefinitions()
    {
        return count($this->parametersDefinitions) > 0;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasParameterDefinition($name)
    {
        return $this->getParameterDefinition($name) !== null;
    }

    /**
     * Set ParametersTemplates.
     *
     * @param \stdClass[] $parametersTemplates
     * @return PuppetClass
     */
    public function setParametersTemplates($parametersTemplates)
    {
        $this->parametersTemplates = $parametersTemplates;
        return $this;
    }

    /**
     * @param \stdClass $parameterTemplate
     * @return PuppetClass
     */
    public function addParameterTemplate($parameterTemplate)
    {
        $this->parametersTemplates[] = $parameterTemplate;
        return $this;
    }

    /**
     * Get ParametersTemplates.
     *
     * @return \stdClass[]
     */
    public function getParametersTemplates()
    {
        return $this->parametersTemplates;
    }

    /**
     * Get specified parameter template.
     *
     * @param string $name
     * @return \stdClass
     */
    public function getParameterTemplate($name)
    {
        if ($this->hasParametersTemplates()) {
            foreach ($this->getParametersTemplates() as $parameterTemplate) {
                if ($parameterTemplate->name === $name) {
                    return $parameterTemplate;
                }
            }
        }
        return null;
    }

    /**
     * @return bool
     */
    public function hasParametersTemplates()
    {
        return count($this->parametersTemplates) > 0;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasParameterTemplate($name)
    {
        return $this->getParameterTemplate($name) !== null;
    }
}
