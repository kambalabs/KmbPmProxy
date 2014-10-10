<?php
namespace KmbPmProxyTest\Model;

use KmbDomain\Model\ParameterType;
use KmbPmProxy\Model\PuppetClass;

class PuppetClassTest extends \PHPUnit_Framework_TestCase
{
    use ParameterFactoryTrait;

    /** @var PuppetClass */
    protected $class;

    /** @var \stdClass */
    protected $parameterTemplate;

    /** @var \stdClass */
    protected $parameterDefinition;

    protected function setUp()
    {
        $this->parameterTemplate = $this->createParameter('hostname', true, false, ParameterType::STRING);
        $this->parameterDefinition = $this->createParameter('hostname', true);
        $this->class = new PuppetClass('apache::vhost', [$this->parameterTemplate], [$this->parameterDefinition]);
    }

    /** @test */
    public function canCheckIfHasNotParameterDefinition()
    {
        $class = new PuppetClass('ntp');

        $this->assertFalse($class->hasParameterDefinition('unknown'));
    }

    /** @test */
    public function canCheckIfHasParameterDefinition()
    {
        $this->assertTrue($this->class->hasParameterDefinition('hostname'));
    }

    /** @test */
    public function cannotGetUnknownParameterDefinition()
    {
        $class = new PuppetClass('ntp');

        $this->assertNull($class->getParameterDefinition('unknown'));
    }

    /** @test */
    public function canGetParameterDefinition()
    {
        $this->assertEquals($this->parameterDefinition, $this->class->getParameterDefinition('hostname'));
    }

    /** @test */
    public function canCheckIfHasNotParameterTemplate()
    {
        $class = new PuppetClass('ntp');

        $this->assertFalse($class->hasParameterTemplate('unknown'));
    }

    /** @test */
    public function canCheckIfHasParameterTemplate()
    {
        $this->assertTrue($this->class->hasParameterTemplate('hostname'));
    }

    /** @test */
    public function cannotGetUnknownParameterTemplate()
    {
        $class = new PuppetClass('ntp');

        $this->assertNull($class->getParameterTemplate('unknown'));
    }

    /** @test */
    public function canGetParameterTemplate()
    {
        $this->assertEquals($this->parameterTemplate, $this->class->getParameterTemplate('hostname'));
    }
}
