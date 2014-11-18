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
namespace KmbPmProxy\Validator;

use KmbPmProxy\Model\PuppetClass;
use Zend\Validator\AbstractValidator;
use Zend\Validator\Exception;

class PuppetClassValidator extends AbstractValidator
{
    const MSG_REQUIRED = 'required';
    const MSG_NOT_REQUIRED = 'notRequired';
    const MSG_MISSING_PARAMETER = 'missingParameter';
    const MSG_UNDEFINED_PARAMETER = 'undefinedParameter';

    protected $messageTemplates;

    public function __construct($options = null)
    {
        $this->messageTemplates = [
            self::MSG_REQUIRED => $this->translate("Parameter '%value%' should be set as required in the class template"),
            self::MSG_NOT_REQUIRED => $this->translate("Parameter '%value%' shouldn't be set as required in the class template"),
            self::MSG_MISSING_PARAMETER => $this->translate("Parameter '%value%' is missing in the class template"),
            self::MSG_UNDEFINED_PARAMETER => $this->translate("Parameter '%value%' is not defined in the class"),
        ];
        parent::__construct($options);
    }

    /**
     * Returns true if and only if $value meets the validation requirements
     *
     * If $value fails validation, then this method returns false, and
     * getMessages() will return an array of messages that explain why the
     * validation failed.
     *
     * @param  PuppetClass $value
     * @return bool
     * @throws Exception\RuntimeException If validation of $value is impossible
     */
    public function isValid($value)
    {
        foreach ($value->getParametersDefinitions() as $parameterDefinition) {
            $name = $parameterDefinition->name;
            $parameterTemplate = $value->getParameterTemplate($name);
            if ($parameterTemplate === null) {
                $this->abstractOptions['messages'][$name] = $this->createMessage(self::MSG_MISSING_PARAMETER, $name);
            } elseif ($parameterDefinition->required !== $parameterTemplate->required) {
                $this->abstractOptions['messages'][$name] = $this->createMessage(
                    $parameterDefinition->required ? self::MSG_REQUIRED : self::MSG_NOT_REQUIRED,
                    $name
                );
            }
        }

        foreach ($value->getParametersTemplates() as $parameterTemplate) {
            $name = $parameterTemplate->name;
            if (!$value->hasParameterDefinition($name)) {
                $this->abstractOptions['messages'][$name] = $this->createMessage(self::MSG_UNDEFINED_PARAMETER, $name);
            }
        }

        return count($this->getMessages()) === 0;
    }

    /**
     * Awful hack to allow POEdit to detect messages to translate.
     *
     * @param string $text
     * @return string
     */
    protected function translate($text)
    {
        return $text;
    }
}
