<?php
namespace KmbPmProxyTest\Service;

use KmbPmProxy\Service\PuppetModule;
use KmbPmProxyTest\Bootstrap;

class PuppetModuleFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function canCreateService()
    {
        /** @var PuppetModule $service */
        $service = Bootstrap::getServiceManager()->get('KmbPmProxy\Service\PuppetModule');

        $this->assertInstanceOf('KmbPmProxy\Service\PuppetModule', $service);
        $this->assertInstanceOf('KmbPmProxy\Client', $service->getPmProxyClient());
        $this->assertInstanceOf('KmbPmProxy\Options\ModuleOptions', $service->getOptions());
    }
}
