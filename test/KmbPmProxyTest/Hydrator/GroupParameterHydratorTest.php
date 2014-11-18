<?php
namespace KmbPmProxyTest\Hydrator;

use KmbDomain\Model\GroupParameter;
use KmbDomain\Model\GroupParameterType;
use KmbPmProxy\Hydrator\GroupParameterHydrator;
use Zend\Json\Json;

class GroupParameterHydratorTest extends \PHPUnit_Framework_TestCase
{
    /** @var  GroupParameterHydrator */
    protected $hydrator;

    protected function setUp()
    {
        $this->hydrator = new GroupParameterHydrator();
    }

    /** @test */
    public function canHydrateBooleanTemplate()
    {
        $parameter = new GroupParameter();
        $parameter->setName('present');
        $parameter->setValues(['0']);
        $template = $this->createBooleanTemplate();

        $this->hydrator->hydrate($template, $parameter);

        $this->assertEquals($template, $parameter->getTemplate());
        $this->assertEquals([false], $parameter->getValues());
    }

    /** @test */
    public function canHydrateStringTemplate()
    {
        $parameter = new GroupParameter();
        $parameter->setName('ports');
        $parameter->setValues(['80', '443']);
        $template = $this->createPredefinedListTemplate();

        $this->hydrator->hydrate($template, $parameter);

        $this->assertEquals($template, $parameter->getTemplate());
        $this->assertEquals(['8080', '9090'], $parameter->getAvailableValues());
    }

    /** @test */
    public function canHydrateHashtableTemplate()
    {
        $child1 = new GroupParameter();
        $child1->setName('user');
        $child1->setValues(['jdoe']);
        $child2 = new GroupParameter();
        $child2->setName('homedir');
        $child2->setValues(['/home/jdoe']);
        $parameter = new GroupParameter();
        $parameter->setName('admin');
        $parameter->setChildren([$child1, $child2]);
        $template = $this->createHashtableTemplate();

        $this->hydrator->hydrate($template, $parameter);

        $this->assertEquals($template, $parameter->getTemplate());
        $child1Template = $child1->getTemplate();
        $this->assertNotNull($child1Template);
        $this->assertEquals('user', $child1Template->name);
        $availableChildren = $parameter->getAvailableChildren();
        $this->assertEquals(1, count($availableChildren));
        $this->assertEquals('group', $availableChildren[0]->name);
    }

    /** @test */
    public function canHydrateEditableHashtableTemplate()
    {
        $granchild1 = new GroupParameter();
        $granchild1->setName('user');
        $granchild1->setValues(['jdoe']);
        $granchild2 = new GroupParameter();
        $granchild2->setName('homedir');
        $granchild2->setValues(['/home/jdoe']);
        $child = new GroupParameter();
        $child->setName('root');
        $child->setChildren([$granchild1, $granchild2]);
        $parameter = new GroupParameter();
        $parameter->setName('sshusers');
        $parameter->setChildren([$child]);
        $template = $this->createEditableHashtableTemplate();

        $this->hydrator->hydrate($template, $parameter);

        $this->assertEquals($template, $parameter->getTemplate());
        $childTemplate = $child->getTemplate();
        $this->assertNotNull($childTemplate);
        $this->assertEquals('sshusers', $childTemplate->name);
        $granchild1Template = $granchild1->getTemplate();
        $this->assertNotNull($granchild1Template);
        $this->assertEquals('user', $granchild1Template->name);
        $availableChildren = $child->getAvailableChildren();
        $this->assertEquals(3, count($availableChildren));
        $this->assertEquals('group', $availableChildren[0]->name);
        $this->assertEquals(['jmiller', 'psmith'], $granchild1->getAvailableValues());
    }

    protected function createBooleanTemplate()
    {
        return Json::decode(Json::encode([
            'name' => 'present',
            'required' => true,
            'multiple_values' => false,
            'type' => GroupParameterType::BOOLEAN,
        ]));
    }

    protected function createPredefinedListTemplate()
    {
        return Json::decode(Json::encode([
            'name' => 'ports',
            'required' => true,
            'multiple_values' => true,
            'type' => GroupParameterType::PREDEFINED_LIST,
            'values' => ['80', '443', '8080', '9090'],
        ]));
    }

    protected function createHashtableTemplate()
    {
        return Json::decode(Json::encode([
            'name' => 'admin',
            'required' => true,
            'multiple_values' => false,
            'type' => GroupParameterType::HASHTABLE,
            'entries' => [
                [
                    'name' => 'homedir',
                    'required' => true,
                    'multiple_values' => false,
                    'type' => GroupParameterType::STRING,
                ],
                [
                    'name' => 'user',
                    'required' => false,
                    'multiple_values' => false,
                    'type' => GroupParameterType::STRING,
                ],
                [
                    'name' => 'group',
                    'required' => false,
                    'multiple_values' => true,
                    'type' => GroupParameterType::STRING,
                ],
            ]
        ]));
    }

    protected function createEditableHashtableTemplate()
    {
        return Json::decode(Json::encode([
            'name' => 'sshusers',
            'required' => true,
            'multiple_values' => false,
            'type' => GroupParameterType::EDITABLE_HASHTABLE,
            'entries' => [
                [
                    'name' => 'user',
                    'required' => true,
                    'multiple_values' => false,
                    'type' => GroupParameterType::PREDEFINED_LIST,
                    'values' => [
                        'jdoe',
                        'jmiller',
                        'psmith',
                    ],
                ],
                [
                    'name' => 'homedir',
                    'required' => true,
                    'multiple_values' => false,
                    'type' => GroupParameterType::STRING,
                ],
                [
                    'name' => 'group',
                    'required' => false,
                    'multiple_values' => true,
                    'type' => GroupParameterType::STRING,
                ],
                [
                    'name' => 'keypath',
                    'required' => false,
                    'multiple_values' => false,
                    'type' => GroupParameterType::STRING,
                ],
                [
                    'name' => 'keygroup',
                    'required' => false,
                    'multiple_values' => false,
                    'type' => GroupParameterType::STRING,

                ],
            ]
        ]));
    }
}
