<?php

namespace Globalis\Universign\Request;

class DocSignatureField extends Base
{
    protected $attributesDefinitions = [
        'name' => 'string',
        'page' => 'int',
        'x' => 'int',
        'y' => 'int',
        'signerIndex' => 'int',
        'patternName' => 'string',
        'label' => 'string'
    ];
}
