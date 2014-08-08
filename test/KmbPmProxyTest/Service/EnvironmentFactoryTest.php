<?php
namespace KmbPmProxyTest\Service;

use KmbPmProxyTest\Bootstrap;

class EnvironmentFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function canCreateService()
    {
        /** @var \KmbPmProxy\Service\Environment $service */
        $service = Bootstrap::getServiceManager()->get('KmbPmProxy\Service\Environment');

        $this->assertInstanceOf('KmbPmProxy\Service\Environment', $service);
        $this->assertInstanceOf('KmbPmProxy\Client', $service->getPmProxyClient());
        $this->assertInstanceOf('KmbPmProxy\Model\EnvironmentHydrator', $service->getEnvironmentHydrator());
    }
}
