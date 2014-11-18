<?php
namespace KmbPmProxyTest\Hydrator;

use KmbPmProxy\Hydrator\GroupHydrator;
use KmbPmProxyTest\Bootstrap;

class GroupHydratorFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function canCreateService()
    {
        /** @var GroupHydrator $service */
        $service = Bootstrap::getServiceManager()->get('pmProxyGroupHydrator');

        $this->assertInstanceOf('KmbPmProxy\Hydrator\GroupHydrator', $service);
        $this->assertInstanceOf('KmbPmProxy\Hydrator\GroupClassHydrator', $service->getGroupClassHydrator());
    }
}
