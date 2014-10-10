<?php
namespace KmbPmProxyTest\Service;

use KmbDomain\Model\Environment;
use KmbPmProxy\Model\Module;
use KmbPmProxy\Service\PuppetClass;

class PuppetClassTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function cannotGetUnknownByEnvironmentAndName()
    {
        $moduleService = $this->getMock('KmbPmProxy\Service\ModuleInterface');
        $moduleService->expects($this->any())
            ->method('getAllByEnvironment')
            ->will($this->returnValue([]));
        $puppetClassService = new PuppetClass();
        $puppetClassService->setModuleService($moduleService);

        $puppetClass = $puppetClassService->getByEnvironmentAndName(new Environment(), 'unknown');

        $this->assertNull($puppetClass);
    }

    /** @test */
    public function canGetByEnvironmentAndName()
    {
        $expectedPuppetClass = new \KmbPmProxy\Model\PuppetClass('ntp');
        $module = new Module('ntp', '1.0');
        $module->setClasses([$expectedPuppetClass]);
        $moduleService = $this->getMock('KmbPmProxy\Service\ModuleInterface');
        $moduleService->expects($this->any())
            ->method('getAllByEnvironment')
            ->will($this->returnValue([$module]));
        $puppetClassService = new PuppetClass();
        $puppetClassService->setModuleService($moduleService);

        $puppetClass = $puppetClassService->getByEnvironmentAndName(new Environment(), 'ntp');

        $this->assertEquals($expectedPuppetClass, $puppetClass);
    }
}
