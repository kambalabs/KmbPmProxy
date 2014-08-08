<?php
namespace KmbPmProxyTest\Service;

use KmbDomain\Model\Environment;
use KmbPmProxy\Model\Module;
use KmbPmProxy\Model\PuppetClass;
use KmbPmProxy\Options\ModuleOptions;
use KmbPmProxy\Service;
use Zend\Json\Json;

class ModuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $pmProxyClientMock;

    /**
     * @var Service\Module
     */
    private $moduleService;

    protected function setUp()
    {
        $this->pmProxyClientMock = $this->createClientMock();
        $this->moduleService = new Service\Module();
        $this->moduleService->setOptions(new ModuleOptions());
        $this->moduleService->setPmProxyClient($this->pmProxyClientMock);
    }

    /** @test */
    public function canGetAllByEnvironment()
    {
        $environment = new Environment();
        $environment->setId(1);
        $modules = $this->moduleService->getAllByEnvironment($environment);

        $this->assertEquals(1, count($modules));
        /** @var Module $firstModule */
        $firstModule = $modules[0];
        $this->assertInstanceOf('KmbPmProxy\Model\Module', $firstModule);
        $this->assertEquals('apache', $firstModule->getName());
        $classes = $firstModule->getClasses();
        $this->assertEquals(1, count($classes));
        /** @var PuppetClass $firtClass */
        $firtClass = $classes[0];
        $this->assertInstanceOf('KmbPmProxy\Model\PuppetClass', $firtClass);
        $this->assertEquals('apache::vhost', $firtClass->getName());
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function createClientMock()
    {
        $client = $this->getMock('KmbPmProxy\ClientInterface');
        $client->expects($this->any())
            ->method('get')
            ->with('/environments/1/modules')
            ->will($this->returnValue(Json::decode(Json::encode([
                [
                    'name' => 'apache',
                    'version' => '1.0.0',
                    'source' => 'http://github.com/kambalabs/apache-module',
                    'project_page' => 'http://github.com/kambalabs/apache-module',
                    'issues_url' => 'http://github.com/kambalabs/apache-module/issues',
                    'author' => 'John DOE',
                    'summary' => 'Puppet scenario for Apache',
                    'license' => 'MIT',
                    'classes' => [
                        [
                            'name' => 'apache::vhost',
                            'doc' => '== Class apache::vhost',
                            'template_definitions' => [
                                [
                                    'name' => 'hostname',
                                    'required' => true,
                                    'multiple_values' => false,
                                    'type' => 'free-entry',
                                ],
                            ],
                            'parameters_definitions' => [
                                [
                                    'name' => 'hostname',
                                    'required' => true,
                                ],
                            ],
                        ],
                    ],
                ],
            ]))));
        return $client;
    }
}
