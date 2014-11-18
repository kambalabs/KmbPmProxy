<?php
namespace KmbPmProxyTest\Hydrator;

use KmbDomain\Model\GroupParameter;
use KmbDomain\Model\GroupParameterType;
use KmbDomain\Model\GroupClass;
use KmbPmProxy\Hydrator\GroupClassHydrator;
use KmbPmProxy\Hydrator\GroupParameterHydrator;
use Zend\Json\Json;

class GroupClassHydratorTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function canSetParametersTemplates()
    {
        $hydrator = new GroupClassHydrator();
        $hydrator->setGroupParameterHydrator(new GroupParameterHydrator());
        $parameter = new GroupParameter();
        $parameter->setName('nameserver');
        $class = new GroupClass();
        $class->setParameters([new GroupParameter(), $parameter, new GroupParameter()]);
        $template = $this->createTemplate('nameserver');
        $otherTemplate = $this->createTemplate('other');

        $hydrator->hydrate([$template, $otherTemplate], $class);

        $this->assertEquals($template, $parameter->getTemplate());
        $this->assertEquals([$otherTemplate], $class->getAvailableParameters());
    }

    /**
     * @param $name
     * @param $required
     * @param $multipleValues
     * @param $type
     * @return mixed
     */
    protected function createTemplate($name, $required = true, $multipleValues = false, $type = GroupParameterType::STRING)
    {
        return Json::decode(Json::encode([
            'name' => $name,
            'required' => $required,
            'multiple_values' => $multipleValues,
            'type' => $type,
        ]));
    }
}
