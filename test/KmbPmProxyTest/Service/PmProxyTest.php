<?php
namespace KmbPmProxyTest\Service;

use KmbPmProxy\Model\EnvironmentHydrator;
use KmbPmProxyTest\Bootstrap;
use KmbDomain\Model\Environment;
use KmbPmProxy\Service;
use Zend\Log\Logger;

class PmProxyTest extends \PHPUnit_Framework_TestCase
{
    /** @var Service\PmProxy */
    protected $pmProxyService;

    /** @var  \PHPUnit_Framework_MockObject_MockObject */
    protected $httpClient;

    /** @var  \PHPUnit_Framework_MockObject_MockObject */
    protected $httpResponse;

    protected function setUp()
    {
        /** @var Logger $logger */
        $logger = Bootstrap::getServiceManager()->get('Logger');
        $this->httpClient = $this->getMock('Zend\Http\Client');
        $this->httpResponse = $this->getMock('Zend\Http\Response');
        $this->httpClient->expects($this->any())
            ->method('send')
            ->will($this->returnValue($this->httpResponse));
        $this->pmProxyService = new Service\PmProxy();
        $this->pmProxyService->setBaseUri('http://localhost');
        $this->pmProxyService->setEnvironmentHydrator(new EnvironmentHydrator());
        $this->pmProxyService->setLogger($logger);
        $this->pmProxyService->setHttpClient($this->httpClient);
    }

    /**
     * @test
     * @expectedException \KmbPmProxy\Exception\RuntimeException
     * @expectedExceptionMessage Save error
     */
    public function cannotSaveWhenRequestFails()
    {
        $this->httpResponse->expects($this->any())
            ->method('isSuccess')
            ->will($this->returnValue(false));
        $this->httpResponse->expects($this->any())
            ->method('getBody')
            ->will($this->returnValue('{"message":"Save error"}'));

        $this->pmProxyService->save($this->createEnvironment(1, 'STABLE'));
    }

    /** @test */
    public function canSave()
    {
        $this->httpResponse->expects($this->any())
            ->method('isSuccess')
            ->will($this->returnValue(true));

        $this->pmProxyService->save($this->createEnvironment(1, 'STABLE'));
    }

    /**
     * @test
     * @expectedException \KmbPmProxy\Exception\RuntimeException
     * @expectedExceptionMessage Remove error
     */
    public function cannotRemoveWhenRequestFails()
    {
        $this->httpResponse->expects($this->any())
            ->method('isSuccess')
            ->will($this->returnValue(false));
        $this->httpResponse->expects($this->any())
            ->method('getBody')
            ->will($this->returnValue('{"message":"Remove error"}'));

        $this->pmProxyService->remove($this->createEnvironment(1, 'STABLE'));
    }

    /**
     * @test
     * @expectedException \KmbPmProxy\Exception\RuntimeException
     * @expectedExceptionMessage HTTP/1.0 500 Internal Server Error
     */
    public function cannotRemoveWhenRequestFailsWithoutMessage()
    {
        $this->httpResponse->expects($this->any())
            ->method('isSuccess')
            ->will($this->returnValue(false));
        $this->httpResponse->expects($this->any())
            ->method('getBody')
            ->will($this->returnValue(''));
        $this->httpResponse->expects($this->any())
            ->method('renderStatusLine')
            ->will($this->returnValue('HTTP/1.0 500 Internal Server Error'));

        $this->pmProxyService->remove($this->createEnvironment(1, 'STABLE'));
    }

    /** @test */
    public function canRemove()
    {
        $this->httpResponse->expects($this->any())
            ->method('isSuccess')
            ->will($this->returnValue(true));

        $this->pmProxyService->save($this->createEnvironment(1, 'STABLE'));
    }

    /**
     * @test
     * @expectedException \KmbPmProxy\Exception\NotFoundException
     */
    public function cannotRemoveUnknownEnvironment()
    {
        $this->httpResponse->expects($this->any())
            ->method('isNotFound')
            ->will($this->returnValue(true));

        $this->pmProxyService->remove($this->createEnvironment(1, 'STABLE'));
    }

    protected function createEnvironment($id, $name, $parent = null)
    {
        $environment = new Environment();
        $environment->setId($id);
        $environment->setName($name);
        $environment->setParent($parent);
        return $environment;
    }
}
