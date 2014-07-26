<?php
namespace KmbPmProxyTest\Service;

use KmbPmProxy\Service\PmProxyFactory;
use KmbPmProxyTest\Bootstrap;

class PmProxyFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function canCreateService()
    {
        $factory = new PmProxyFactory();

        /** @var \KmbPmProxy\Service\PmProxy $service */
        $service = $factory->createService(Bootstrap::getServiceManager());

        $this->assertInstanceOf('KmbPmProxy\Service\PmProxy', $service);
        $this->assertInstanceOf('Zend\Http\Client', $service->getHttpClient());
        $this->assertEquals('http://localhost:3000', $service->getBaseUri());
        $this->assertInstanceOf('KmbPmProxy\Model\EnvironmentHydrator', $service->getEnvironmentHydrator());
        $this->assertInstanceOf('Zend\Log\Logger', $service->getLogger());
    }
}
