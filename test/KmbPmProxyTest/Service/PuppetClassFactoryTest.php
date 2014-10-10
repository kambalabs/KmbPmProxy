<?php
namespace KmbPmProxyTest\Service;

use KmbPmProxy\Service\PuppetClass;
use KmbPmProxyTest\Bootstrap;

class PuppetClassFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function canCreateService()
    {
        /** @var PuppetClass $service */
        $service = Bootstrap::getServiceManager()->get('pmProxyPuppetClassService');

        $this->assertInstanceOf('KmbPmProxy\Service\PuppetClassInterface', $service);
        $this->assertInstanceOf('KmbPmProxy\Service\ModuleInterface', $service->getModuleService());
    }
}
