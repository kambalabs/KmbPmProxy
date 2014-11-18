<?php
namespace KmbPmProxyTest\Hydrator;

use KmbDomain\Model\Group;
use KmbDomain\Model\GroupClass;
use KmbDomain\Model\Revision;
use KmbPmProxy\Hydrator\GroupHydrator;
use KmbPmProxy\Hydrator\RevisionHydrator;
use KmbPmProxy\Model\PuppetClass;
use KmbPmProxy\Model\PuppetModule;

class RevisionHydratorTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function canHydrate()
    {
        $module = new PuppetModule('dns', '1.0');
        $module->setClasses([new PuppetClass('dns'), new PuppetClass('dns::install'), new PuppetClass('dns::setup')]);
        $group = new Group('dns');
        $group->addClass(new GroupClass('dns'));
        $groupHydrator = new GroupHydrator();
        $groupHydrator->setGroupClassHydrator($this->getMock('KmbPmProxy\Hydrator\GroupClassHydratorInterface'));
        $hydrator = new RevisionHydrator();
        $hydrator->setGroupHydrator($groupHydrator);
        $revision = new Revision();
        $revision->setGroups([$group]);

        $hydrator->hydrate([$module], $revision);

        $this->assertEquals(['dns' => ['dns::install', 'dns::setup']], $group->getAvailableClasses());
    }
}
