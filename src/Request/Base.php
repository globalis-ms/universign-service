<?php

namespace Globalis\Universign\Request;

use \InvalidArgumentException;
use \UnexpectedValueException;
use PhpXmlRpc\Value as PhpXmlRpcValue;

abstract class Base
{

    protected $attributes = [];

    protected $attributesDefinitions = [];

    public function getAttributes()
    {
        return array_filter($this->attributes);
    }

    public function buildRpcValues()
    {
        $build = [];
        foreach ($this->attributes as $key => $value) {
            $build[$key] = $this->buildRpcValue($value, $this->attributesDefinitions[$key]);
        }
        return new PhpXmlRpcValue($build, PhpXmlRpcValue::$xmlrpcStruct);
    }

    protected function buildRpcValue($value, $type = null)
    {
        if (!$type) {
            $type = gettype($value);
        }
        switch ($type) {
            case 'string':
                return new PhpXmlRpcValue($value, PhpXmlRpcValue::$xmlrpcString);
            case 'base64':
                return new PhpXmlRpcValue($value, PhpXmlRpcValue::$xmlrpcBase64);
            case 'array':
                $data = [];
                foreach ($value as $v) {
                    $data[] = $this->buildRpcValue($v);
                }
                return new PhpXmlRpcValue($data, PhpXmlRpcValue::$xmlrpcArray);
            case 'double':
            case 'float':
                return new PhpXmlRpcValue($value, PhpXmlRpcValue::$xmlrpcDouble);
            case 'boolean':
            case 'bool':
                return new PhpXmlRpcValue($value, PhpXmlRpcValue::$xmlrpcBoolean);
            case 'integer':
            case 'int':
                return new PhpXmlRpcValue($value, PhpXmlRpcValue::$xmlrpcInt);
            default:
                if ($value instanceof self) {
                    return $value->buildRpcValues();
                }
                if ($value instanceof \Datetime) {
                    return new PhpXmlRpcValue($value, PhpXmlRpcValue::$xmlrpcDateTime);
                }
                return new PhpXmlRpcValue($value);
        }
    }

    protected function extractParamNameFromSetter($method)
    {
        return lcfirst(substr($method, 3));
    }

    public function __call($method, $parameters)
    {
        if (preg_match('/^set(.+)$/', $method)) {
            $name = $this->extractParamNameFromSetter($method);
            $this->{$name} = $parameters[0];
            return $this;
        }
    }

    public function __set($name, $value)
    {
        if (!isset($this->attributesDefinitions[$name])) {
            throw new UnexpectedValueException("Undefined property: $name");
        }

        switch ($this->attributesDefinitions[$name]) {
            case 'base64':
            case 'string':
                if (!is_string($value)) {
                    throw new UnexpectedValueException("$name must be of the type string, " . gettype($value) . " given");
                }
                break;
            case 'array':
                // @TODO array[type] ??? or closure ?
                if (!is_array($value)) {
                    throw new UnexpectedValueException("$name must be of the type array, " . gettype($value) . " given");
                }
                break;
            case 'double':
            case 'float':
                if (!is_float($value)) {
                    throw new UnexpectedValueException("$name must be of the type float, " . gettype($value) . " given");
                }
                break;
            case 'boolean':
            case 'bool':
                if (!is_bool($value)) {
                    throw new UnexpectedValueException("$name must be of the type boolean, " . gettype($value) . " given");
                }
                break;
            case 'integer':
            case 'int':
                if (!is_integer($value)) {
                    throw new UnexpectedValueException("$name must be of the type integer, " . gettype($value) . " given");
                }
                break;
            default:
                if (!($value instanceof $this->attributesDefinitions[$name])) {
                    throw new UnexpectedValueException("$name must be of the type " . $this->attributesDefinitions[$name] . ", " . get_class($value) . " given");
                }
                break;
        }
        $this->attributes[$name] = $value;
    }
}
