<?php
namespace KmbPmProxyTest\Hydrator;

use KmbPmProxy\Hydrator\GroupClassHydrator;
use KmbPmProxyTest\Bootstrap;

class GroupClassHydratorFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function canCreateService()
    {
        /** @var GroupClassHydrator $service */
        $service = Bootstrap::getServiceManager()->get('pmProxyGroupClassHydrator');

        $this->assertInstanceOf('KmbPmProxy\Hydrator\GroupClassHydrator', $service);
        $this->assertInstanceOf('KmbPmProxy\Hydrator\GroupParameterHydrator', $service->getGroupParameterHydrator());
    }
}
