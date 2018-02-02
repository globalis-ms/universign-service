<?php

namespace Globalis\Universign\Response;

use Datetime;
use DateTimeZone;
use PhpXmlRpc\Value;
use stdClass;
use UnexpectedValueException;

abstract class Base
{
    protected $attributesDefinitions = [];

    protected $attributes = [];

    public function __construct(Value $values)
    {
        foreach ($this->attributesDefinitions as $key => $value) {
            $this->attributes[$key] = $this->parseValue($values, $key);
        }
    }

    protected function parseValue(Value $values, $key = null)
    {
        if (isset($key)) {
            if (!$values[$key]) {
                return null;
            }
            $values = $values[$key];

            if (is_callable([$this, $this->attributesDefinitions[$key]])) {
                return $this->{$this->attributesDefinitions[$key]}($values);
            }
        }
        switch ($values->scalartyp()) {
            case 'dateTime.iso8601':
                return  Datetime::createFromFormat('Ymd\TH:i:s', $values->scalarval(), new DateTimeZone('UTC'));
            case 'array':
                $data = [];
                foreach ($values->scalarval() as $val) {
                    $data = $this->parseValue($val);
                }
                return $data;
            case 'struct':
                $data = new stdClass();
                foreach ($values->scalarval() as $key => $val) {
                    $data->$key = $this->parseValue($val);
                }
                return $data;
            default:
                return $values->scalarval();
                break;
        }
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function __get($key)
    {
        if (!isset($this->attributesDefinitions[$key])) {
            throw new UnexpectedValueException("Undefined property: $key");
        }

        return $this->attributes[$key];
    }
}
