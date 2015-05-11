<?php
namespace KmbPmProxyTest\Model;

use KmbPmProxy\Model\PuppetModule;
use KmbPmProxy\Model\PuppetClass;

class PuppetModuleTest extends \PHPUnit_Framework_TestCase
{
    /** @var PuppetModule */
    protected $module;

    protected function setUp()
    {
        $this->module = new PuppetModule('apache', '1.0.0');
        $this->module->setClasses([new PuppetClass('apache::vhost')]);
        $this->module->setAvailableVersions(['1.0.1', '1.0.0', '0.0.0-124-1ad030a-unstable']);
    }

    /** @test */
    public function canCheckIfHasNotClass()
    {
        $module = new PuppetModule('apache', '1.0.0');

        $this->assertFalse($module->hasClass('unknown'));
    }

    /** @test */
    public function canCheckIfHasClass()
    {
        $this->assertTrue($this->module->hasClass('apache::vhost'));
    }

    /** @test */
    public function cannotGetUnknownClass()
    {
        $module = new PuppetModule('apache', '1.0.0');

        $this->assertNull($module->getClass('unknown'));
    }

    /** @test */
    public function canGetClass()
    {
        $class = $this->module->getClass('apache::vhost');

        $this->assertInstanceOf('KmbPmProxy\Model\PuppetClass', $class);
        $this->assertEquals('apache::vhost', $class->getName());
    }

    /** @test */
    public function cannotGetAvailableVersionMatchingBranchForUnknownBranch()
    {
        $this->assertNull($this->module->getAvailableVersionMatchingBranch('unknown'));
    }

    /** @test */
    public function canGetAvailableVersionMatchingBranch()
    {
        $this->assertEquals('0.0.0-124-1ad030a-unstable', $this->module->getAvailableVersionMatchingBranch('unstable'));
    }
}
