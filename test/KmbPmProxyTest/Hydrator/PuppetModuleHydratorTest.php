<?php
namespace KmbPmProxyTest\Hydrator;

use KmbPmProxy\Model\PuppetModule;

class PuppetModuleHydratorTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function canHydrate()
    {
        $module = new PuppetModule();
        $hydrator = new \KmbPmProxy\Hydrator\PuppetModuleHydrator();

        $module = $hydrator->hydrate([
            'name' => 'ntp',
            'version' => '1.0.0',
            'source' => 'http://github.com/kambalabs/ntp-module',
            'project_page' => 'http://github.com/kambalabs/ntp-module',
            'issues_url' => 'http://github.com/kambalabs/ntp-module/issues',
            'author' => 'John DOE',
            'summary' => 'Manage NTP service',
            'license' => 'MIT',
        ], $module);

        $this->assertEquals('ntp', $module->getName());
        $this->assertEquals('1.0.0', $module->getVersion());
        $this->assertEquals('http://github.com/kambalabs/ntp-module', $module->getSource());
        $this->assertEquals('http://github.com/kambalabs/ntp-module', $module->getProjectPage());
        $this->assertEquals('http://github.com/kambalabs/ntp-module/issues', $module->getIssuesUrl());
        $this->assertEquals('John DOE', $module->getAuthor());
        $this->assertEquals('Manage NTP service', $module->getSummary());
        $this->assertEquals('MIT', $module->getLicense());
    }
}
