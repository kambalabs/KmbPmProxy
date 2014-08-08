<?php
namespace KmbPmProxyTest;

use KmbPmProxy\Client;
use KmbPmProxy\Options\ModuleOptions;
use Zend\Log\Logger;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    /** @var Client */
    protected $pmProxyClient;

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
        $this->pmProxyClient = new Client();
        $this->pmProxyClient->setOptions(new ModuleOptions());
        $this->pmProxyClient->setLogger($logger);
        $this->pmProxyClient->setHttpClient($this->httpClient);
    }

    /**
     * @test
     * @expectedException \KmbPmProxy\Exception\RuntimeException
     * @expectedExceptionMessage Put error
     */
    public function cannotPutWhenRequestFails()
    {
        $this->httpResponse->expects($this->any())
            ->method('isSuccess')
            ->will($this->returnValue(false));
        $this->httpResponse->expects($this->any())
            ->method('getBody')
            ->will($this->returnValue('{"message":"Put error"}'));

        $this->pmProxyClient->put('/environments/1', [
            'name' => 'STABLE_PF1',
            'parent' => '1',
        ]);
    }

    /** @test */
    public function canPut()
    {
        $this->httpResponse->expects($this->once())
            ->method('isSuccess')
            ->will($this->returnValue(true));

        $this->pmProxyClient->put('/environments/1', [
            'name' => 'STABLE_PF1',
            'parent' => '1',
        ]);
    }

    /** @test */
    public function canPost()
    {
        $this->httpResponse->expects($this->once())
            ->method('isSuccess')
            ->will($this->returnValue(true));

        $this->pmProxyClient->post('/environments', [
            'name' => 'STABLE_PF1',
            'parent' => '1',
        ]);
    }

    /** @test */
    public function canDelete()
    {
        $this->httpResponse->expects($this->once())
            ->method('isSuccess')
            ->will($this->returnValue(true));

        $this->pmProxyClient->delete('/environments/1');
    }

    /** @test */
    public function canGet()
    {
        $this->httpResponse->expects($this->any())
            ->method('isSuccess')
            ->will($this->returnValue(true));
        $this->httpResponse->expects($this->any())
            ->method('getBody')
            ->will($this->returnValue('[{"name": "apache","version": "3.1"}]'));

        $result = $this->pmProxyClient->get('/environments/1/modules');

        $this->assertEquals('apache', $result[0]->name);
        $this->assertEquals('3.1', $result[0]->version);
    }

    /**
     * @test
     * @expectedException \KmbPmProxy\Exception\NotFoundException
     * @expectedExceptionMessage Unknown resource
     */
    public function cannotGetUnknownResource()
    {
        $this->httpResponse->expects($this->any())
            ->method('isNotFound')
            ->will($this->returnValue(true));
        $this->httpResponse->expects($this->any())
            ->method('getBody')
            ->will($this->returnValue('{"message":"Unknown resource"}'));

        $this->pmProxyClient->get('/unknown');
    }

    /**
     * @test
     * @expectedException \KmbPmProxy\Exception\RuntimeException
     * @expectedExceptionMessage HTTP/1.0 500 Internal Server Error
     */
    public function cannotGetWhenRequestFailsWithoutMessage()
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

        $this->pmProxyClient->get('/environments/1/modules');
    }
}
