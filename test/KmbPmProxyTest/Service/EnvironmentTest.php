<?php
namespace KmbPmProxyTest\Service;

use KmbDomain\Model;
use KmbPmProxy\Hydrator\EnvironmentHydrator;
use KmbPmProxy\Service;
use Zend\Log\Logger;

class EnvironmentTest extends \PHPUnit_Framework_TestCase
{
    /** @var Service\Environment */
    protected $environmentService;

    /** @var  \PHPUnit_Framework_MockObject_MockObject */
    protected $pmProxyClient;

    /** @var Model\EnvironmentInterface */
    protected $environment;

    protected function setUp()
    {
        /** @var Logger $logger */
        $this->pmProxyClient = $this->getMock('KmbPmProxy\Client');
        $this->environmentService = new Service\Environment();
        $this->environmentService->setEnvironmentHydrator(new EnvironmentHydrator());
        $this->environmentService->setPmProxyClient($this->pmProxyClient);
        $itg = $this->createEnvironment(3, 'ITG');
        $pf1 = $this->createEnvironment(2, 'PF1');
        $pf1->addChild($itg);
        $this->environment = $this->createEnvironment(1, 'STABLE');
        $this->environment->addChild($pf1);

    }

    /** @test */
    public function canSave()
    {
        $this->pmProxyClient->expects($this->exactly(6))
            ->method('put')
            ->will($this->returnValue(true));

        $this->environmentService->save($this->environment);
    }

    /** @test */
    public function canRemove()
    {
        $this->pmProxyClient->expects($this->exactly(3))
            ->method('delete')
            ->will($this->returnValue(true));

        $this->environmentService->remove($this->environment);
    }

    /**
     * @param $id
     * @param $name
     * @param $parent
     * @return Model\Environment
     */
    protected function createEnvironment($id, $name, $parent = null)
    {
        $environment = new Model\Environment();
        $environment->setId($id);
        $environment->setName($name);
        $environment->setParent($parent);
        return $environment;
    }
}
