<?php
namespace KmbPmProxyTest\Options;

use KmbPmProxy\Options\ModuleOptions;
use KmbPmProxy\Options\ModuleOptionsFactory;
use KmbPmProxyTest\Bootstrap;

class ModuleOptionsFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function canCreateService()
    {
        $factory = new ModuleOptionsFactory();

        /** @var ModuleOptions $options */
        $options = $factory->createService(Bootstrap::getServiceManager());

        $this->assertInstanceOf('KmbPmProxy\Options\ModuleOptions', $options);
        $this->assertEquals('http://localhost:3001', $options->getBaseUri());
    }
}
