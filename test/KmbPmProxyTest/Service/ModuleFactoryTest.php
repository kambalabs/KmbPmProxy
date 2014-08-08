<?php
namespace KmbPmProxyTest\Service;

use KmbPmProxy\Service\Module;
use KmbPmProxyTest\Bootstrap;

class ModuleFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function canCreateService()
    {
        /** @var Module $service */
        $service = Bootstrap::getServiceManager()->get('KmbPmProxy\Service\Module');

        $this->assertInstanceOf('KmbPmProxy\Service\Module', $service);
        $this->assertInstanceOf('KmbPmProxy\Client', $service->getPmProxyClient());
        $this->assertInstanceOf('KmbPmProxy\Options\ModuleOptions', $service->getOptions());
    }
}
