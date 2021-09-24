<?php

declare(strict_types=1);

namespace PixelOven\Http;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use PHPUnit\Framework\TestCase;

class ModelTest extends TestCase
{
    protected $testPropertyValue = 'testing';

    /**
     * @var Request
     */
    protected $testRequest;

    /**
     * @var StubParentModel
     */
    protected $testModel;

    public function setUp(): void
    {
        parent::setUp();
        $this->testRequest  = Request::createFromBase(SymfonyRequest::create('www.pixeloven.com', 'POST', [
            'parent_property' => $this->testPropertyValue,
            'child' => [
                'child_property' => $this->testPropertyValue
            ],
            'other' => [
                'child_property' => $this->testPropertyValue
            ]
        ]));
        $this->testModel = new StubParentModel($this->testRequest);
    }

    public function testInit()
    {
        $this->assertEquals($this->testPropertyValue, $this->testModel->parent_property);
        $this->assertInstanceOf(StubChildModel::class, $this->testModel->child);
        $this->assertEquals($this->testPropertyValue, $this->testModel->child->child_property);
        $this->assertIsArray($this->testModel->other);
        $this->assertEquals($this->testPropertyValue, $this->testModel->other['child_property']);
    }

    public function testGetRequest()
    {
        $request = $this->testModel->getRequest();
        $this->assertInstanceOf(Request::class, $request);
        $this->assertEquals($this->testRequest, $request);
    }
}
