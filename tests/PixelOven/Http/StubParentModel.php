<?php

declare(strict_types=1);

namespace PixelOven\Http;

/**
 * Class StubParentModel
 * @package PixelOven\Http\Models
 */
class StubParentModel extends Model
{

    protected $relations = [
        'child' => StubChildModel::class
    ];

    /**
     * Parents test property
     * @var string
     */
    public $parent_property;

    /**
     * Reference to child object
     * @var StubChildModel
     */
    public $child;

    /**
     * Reference to an array
     * @var array
     */
    public $other;
}
