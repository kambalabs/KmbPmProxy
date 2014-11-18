<?php
namespace KmbPmProxyTest\Validator;

use KmbDomain\Model\GroupParameterType;
use KmbPmProxy\Model\PuppetClass;
use KmbPmProxy\Validator\PuppetClassValidator;
use KmbPmProxyTest\Model\ParameterFactoryTrait;

class PuppetClassValidatorTest extends \PHPUnit_Framework_TestCase
{
    use ParameterFactoryTrait;

    /** @test */
    public function canValidateValidClass()
    {
        $class = new PuppetClass(
            'apache::vhost',
            [$this->createParameter('hostname', true, false, GroupParameterType::STRING)],
            [$this->createParameter('hostname', true)]
        );
        $validator = new PuppetClassValidator();

        $this->assertTrue($validator->isValid($class));
    }

    /** @test */
    public function canValidateInValidClass()
    {
        $class = new PuppetClass(
            'apache::vhost',
            [
                $this->createParameter('hostname', false, false, GroupParameterType::STRING),
                $this->createParameter('port', true, false, GroupParameterType::STRING),
                $this->createParameter('document_root', true, false, GroupParameterType::STRING),
            ],
            [
                $this->createParameter('hostname', true),
                $this->createParameter('port', false),
                $this->createParameter('directory_index', true),
            ]
        );
        $validator = new PuppetClassValidator();

        $this->assertFalse($validator->isValid($class));
        $this->assertEquals([
            'hostname' => "Parameter 'hostname' should be set as required in the class template",
            'port' => "Parameter 'port' shouldn't be set as required in the class template",
            'directory_index' => "Parameter 'directory_index' is missing in the class template",
            'document_root' => "Parameter 'document_root' is not defined in the class",
        ], $validator->getMessages());
    }
}
