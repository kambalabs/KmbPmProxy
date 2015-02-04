<?php
namespace KmbPmProxyTest\Service;

use KmbDomain\Model\Environment;
use KmbPmProxy\Model\PuppetModule;
use KmbPmProxy\Model\PuppetClass;
use KmbPmProxy\Options\ModuleOptions;
use KmbPmProxy\Service;
use Zend\Json\Json;

class PuppetModuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $pmProxyClientMock;

    /**
     * @var Service\PuppetModule
     */
    private $puppetModuleService;

    protected function setUp()
    {
        $this->pmProxyClientMock = $this->createClientMock();
        $this->puppetModuleService = new Service\PuppetModule();
        $this->puppetModuleService->setOptions(new ModuleOptions());
        $this->puppetModuleService->setPmProxyClient($this->pmProxyClientMock);
    }

    /** @test */
    public function canGetAllAvailable()
    {
        $environment = new Environment();
        $environment->setId(1);

        $modules = $this->puppetModuleService->getAllAvailable();

        $this->assertEquals(5, count($modules));
        /** @var PuppetModule $module */
        $module = $modules['tomcat'];
        $this->assertInstanceOf('KmbPmProxy\Model\PuppetModule', $module);
        $this->assertEquals('tomcat', $module->getName());
        $this->assertEquals([ "1.2.10", "0.9.3", "0.8.1", "0.7.7" ], $module->getAvailableVersions());
    }

    /** @test */
    public function canGetAllInstallableByEnvironment()
    {
        $environment = new Environment();
        $environment->setId(1);

        $modules = $this->puppetModuleService->getAllInstallableByEnvironment($environment);

        $this->assertEquals(3, count($modules));
        /** @var PuppetModule $module */
        $module = $modules['apache'];
        $this->assertInstanceOf('KmbPmProxy\Model\PuppetModule', $module);
        $this->assertEquals('apache', $module->getName());
        $this->assertEquals([ "2.4.10", "2.4.9", "2.4.8", "2.4.7" ], $module->getAvailableVersions());
    }

    /** @test */
    public function canGetAllInstalledByEnvironment()
    {
        $environment = new Environment();
        $environment->setId(1);

        $modules = $this->puppetModuleService->getAllInstalledByEnvironment($environment);

        $this->assertEquals(1, count($modules));
        /** @var PuppetModule $module */
        $module = $modules['apache'];
        $this->assertInstanceOf('KmbPmProxy\Model\PuppetModule', $module);
        $this->assertEquals('apache', $module->getName());
        $classes = $module->getClasses();
        $this->assertEquals(1, count($classes));
        /** @var PuppetClass $firtClass */
        $firtClass = $classes[0];
        $this->assertInstanceOf('KmbPmProxy\Model\PuppetClass', $firtClass);
        $this->assertEquals('apache::vhost', $firtClass->getName());
    }

    /** @test */
    public function cannotGetUnknownModuleByEnvironmentAndName()
    {
        $environment = new Environment();
        $environment->setId(1);

        $module = $this->puppetModuleService->getByEnvironmentAndName($environment, 'unknown');

        $this->assertNull($module);
    }

    /** @test */
    public function canGetByEnvironmentAndName()
    {
        $environment = new Environment();
        $environment->setId(1);

        $module = $this->puppetModuleService->getByEnvironmentAndName($environment, 'apache');

        /** @var PuppetModule $module */
        $this->assertInstanceOf('KmbPmProxy\Model\PuppetModule', $module);
        $this->assertEquals('apache', $module->getName());
        $classes = $module->getClasses();
        $this->assertEquals(1, count($classes));
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function createClientMock()
    {
        $client = $this->getMock('KmbPmProxy\ClientInterface');
        $client->expects($this->any())
            ->method('get')
            ->will($this->returnCallback(function ($uri) {
                $response = [];
                if ($uri == '/environments/1/modules') {
                    $response = [
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
                    ];
                } elseif ($uri == '/modules/available') {
                    $response = [
                        'tomcat' => [
                            "1.2.10",
                            "0.9.3",
                            "0.8.1",
                            "0.7.7",
                        ],
                        'apache' => [
                            "2.4.10",
                            "2.4.9",
                            "2.4.8",
                            "2.4.7",
                        ],
                        'php' => [
                            "5.6.4",
                            "5.5.3",
                            "5.4.9",
                        ],
                        'dns' => [
                            "1.0.0",
                            "0.0.0-master",
                            "0.0.0-unstable"
                        ],
                        'ntp' => [
                            "1.0.1",
                        ],
                    ];
                } elseif ($uri == '/environments/1/modules/installable') {
                    $response = [
                        'apache' => [
                            "2.4.10",
                            "2.4.9",
                            "2.4.8",
                            "2.4.7",
                        ],
                        'php' => [
                            "5.6.4",
                            "5.5.3",
                            "5.4.9",
                        ],
                        'dns' => [
                            "1.0.0",
                            "0.0.0-master",
                            "0.0.0-unstable"
                        ],
                    ];
                }
                return Json::decode(Json::encode($response));
        }));
        return $client;
    }
}
