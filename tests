<?php
declare(strict_types=1);

namespace App\Http\Models;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use TestCase;

/**
 * Class MockParentModel
 * @package App\Http\Models
 */
class MockParentModel extends Model {

    protected $relations = [
        'child' => MockChildModel::class
    ];

    /**
     * Parents test property
     * @var string
     */
    public $parent_property;

    /**
     * Reference to child object
     * @var MockChildModel
     */
    public $child;

    /**
     * Reference to an array
     * @var array
     */
    public $other;
}

/**
 * Class MockChildModel
 * @package App\Http\Models
 */
class MockChildModel extends Model {

    /**
     * Childs test property
     * @var string
     */
    public $child_property;  
}

class ModelTest extends TestCase {

    protected $testPropertyValue = 'testing';

    protected $testRequest;
    protected $testModel;

    public function setUp() {
        parent::setUp();
        $this->testRequest  = Request::createFromBase(SymfonyRequest::create('api.gofundme.com', 'POST', [
            'parent_property' => $this->testPropertyValue,
            'child' => [
                'child_property' => $this->testPropertyValue
            ],
            'other' => [
                'child_property' => $this->testPropertyValue
            ]
        ]));
        $this->testModel = new MockParentModel($this->testRequest);
    }

    public function testInit() {
        $this->assertEquals($this->testPropertyValue, $this->testModel->parent_property);
        $this->assertInstanceOf(MockChildModel::class, $this->testModel->child);
        $this->assertEquals($this->testPropertyValue, $this->testModel->child->child_property);
        $this->assertInternalType('array', $this->testModel->other);
        $this->assertEquals($this->testPropertyValue, $this->testModel->other['child_property']);
    }

    public function testGetRequest() {
        $request = $this->testModel->getRequest();
        $this->assertInstanceOf(Request::class, $request);
        $this->assertEquals($this->testRequest, $request);
    }
}
