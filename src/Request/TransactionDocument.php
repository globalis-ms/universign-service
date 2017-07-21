<?php

namespace Globalis\Universign\Request;

class TransactionDocument extends Base
{
    protected $attributesDefinitions = [
        'content' => 'base64',
        'url' => 'string',
        'name' => 'string',
        'checkBoxTexts' => 'array',
        'metaData' => 'array',
        'signatureFields' => 'array',
    ];


    public function setPath($path)
    {
        if (file_exists($path)) {
            if (!isset($this->attributes['name'])) {
                $this->attributes['name'] = basename($path);
            }
            $this->attributes['content'] = file_get_contents($path);
        }
        return $this;
    }

    public function addSignatureField(DocSignatureField $signatureField)
    {
        $this->attributes['signatureFields'][] = $signatureField;
        return $this;
    }
}
