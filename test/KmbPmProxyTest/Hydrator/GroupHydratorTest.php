<?php
namespace KmbPmProxyTest\Hydrator;

use KmbDomain\Model\Group;
use KmbDomain\Model\GroupClass;
use KmbPmProxy\Hydrator\GroupHydrator;
use KmbPmProxy\Model\PuppetClass;
use KmbPmProxy\Model\PuppetModule;

class GroupHydratorTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function canHydrate()
    {
        $module = new PuppetModule('dns', '1.0');
        $module->setClasses([new PuppetClass('dns'), new PuppetClass('dns::install'), new PuppetClass('dns::setup')]);
        $group = new Group('dns');
        $group->addClass(new GroupClass('dns'));
        $hydrator = new GroupHydrator();
        $hydrator->setGroupClassHydrator($this->getMock('KmbPmProxy\Hydrator\GroupClassHydratorInterface'));

        $hydrator->hydrate([$module], $group);

        $this->assertEquals(['dns' => ['dns::install', 'dns::setup']], $group->getAvailableClasses());
    }
}
