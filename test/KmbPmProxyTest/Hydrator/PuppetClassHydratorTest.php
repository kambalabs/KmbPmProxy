<?php
namespace KmbPmProxyTest\Hydrator;

use KmbPmProxy\Hydrator\PuppetClassHydrator;
use KmbPmProxy\Model\PuppetClass;

class PuppetClassHydratorTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function canHydrate()
    {
        $puppetClass = new PuppetClass();
        $hydrator = new PuppetClassHydrator();

        $puppetClass = $hydrator->hydrate([
            'name' => 'ntp',
            'doc' => '== Class ntp',
            'template_definitions' => [],
            'parameters_definitions' => [],
        ], $puppetClass);

        $this->assertEquals('ntp', $puppetClass->getName());
        $this->assertEquals('== Class ntp', $puppetClass->getDocumentation());
        $this->assertEquals([], $puppetClass->getParametersDefinitions());
        $this->assertEquals([], $puppetClass->getParametersTemplates());
    }
}
