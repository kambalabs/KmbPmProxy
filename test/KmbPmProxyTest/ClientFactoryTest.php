<?php
namespace KmbPmProxyTest;

use KmbPmProxy\Client;

class ClientFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function canCreateService()
    {
        /** @var Client $service */
        $service = Bootstrap::getServiceManager()->get('KmbPmProxy\Client');

        $this->assertInstanceOf('KmbPmProxy\Client', $service);
        $this->assertEquals('http://localhost:3000', $service->getBaseUri());
        $this->assertInstanceOf('Zend\Http\Client', $service->getHttpClient());
        $this->assertInstanceOf('Zend\Log\Logger', $service->getLogger());
    }
}
