<?php
namespace KmbPmProxyTest\Hydrator;

use KmbPmProxyTest\Bootstrap;

class RevisionHydratorFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function canCreateService()
    {
        $service = Bootstrap::getServiceManager()->get('pmProxyRevisionHydrator');

        $this->assertInstanceOf('KmbPmProxy\Hydrator\RevisionHydrator', $service);
        $this->assertInstanceOf('KmbPmProxy\Hydrator\GroupHydrator', $service->getGroupHydrator());
    }
}
