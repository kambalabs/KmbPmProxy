<?php
namespace KmbPmProxyTest\Hydrator;

use KmbDomain\Model\Environment;
use KmbPmProxy\Hydrator\EnvironmentHydrator;

class EnvironmentHydratorTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function canExtract()
    {
        $environment = new Environment();
        $environment->setName('STABLE');
        $hydrator = new EnvironmentHydrator();

        $this->assertEquals(['name' => 'STABLE'], $hydrator->extract($environment));
    }

    /** @test */
    public function canExtractWithParent()
    {
        $parent = new Environment();
        $parent->setId(1);
        $parent->setName('STABLE');
        $environment = new Environment();
        $environment->setName('PF1');
        $environment->setParent($parent);
        $hydrator = new EnvironmentHydrator();

        $this->assertEquals(['name' => 'STABLE_PF1', 'source' => 'STABLE'], $hydrator->extract($environment));
    }
}
