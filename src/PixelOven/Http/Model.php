<?php
declare(strict_types=1);

namespace PixelOven\Http;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\ProvidesConvenienceMethods;
use ReflectionObject;
use ReflectionProperty;

/**
 * Class Model
 * @package App\Http\Models\Model
 */
abstract class Model
{

    use ProvidesConvenienceMethods;

    /**
     * Used to relate properties to other objects
     * @var array
     */
    protected $relations = [];

    /**
     * Nested key for request object
     * @var string
     */
    protected $key;

    /**
     * Incoming request
     * @var Request
     */
    protected $request;

    /**
     * Create a new instance of model
     * @param  Request     $request 
     * @param  string|null $key 
     */
    public function __construct(Request $request, string $key = null) {
        $this->request = $request;
        $this->key     = $key;

        // Fill properties
        $reflection = new ReflectionObject($this);
        $properties = $reflection->getProperties(ReflectionProperty::IS_PUBLIC);
        foreach ($properties as $property) {
            $name  = $property->getName();
            $input = $this->getInput($name);
            $child = $this->getRelation($name);
            if (empty($child)) {
                $property->setValue($this, $input);
            } else {
                $property->setValue($this, $child);
            }
        }
    }

    /**
     * Validate model from request
     *
     * @param array $rules
     * @param array $messages
     * @param array $customAttributes
     */
    public function validate(array $rules, array $messages = [], array $customAttributes = [])
    {
        $validator = $this->getValidationFactory()->make($this->request->all(), $rules, $messages, $customAttributes);

        if ($validator->fails()) {
            $this->throwValidationException($this->request, $validator);
        }
    }

    /**
     * Get request object
     * @return Request
     */
    public function getRequest() : Request {
        return $this->request;
    }

    /**
     * Get input from request
     * @param  string $name
     * @return string|array|null
     */
    protected function getInput(string $name) {
        if (is_null($this->key)) {
            return $this->request->all()[$name] ?? null;
        }
        return $this->request->all()[$this->key][$name] ?? null;
    }

    /**
     * Get relation if it exists for a given element
     * @param  string $name
     * @return Model|null
     */
    protected function getRelation(string $name) {
        if (isset($this->relations[$name]) && class_exists($this->relations[$name])) {
            $class = $this->relations[$name];
            return new $class($this->request, $name);
        }
        return null;
    }
}
