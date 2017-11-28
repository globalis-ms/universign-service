<?php

namespace Globalis\Universign\Request;

class TransactionDocument extends Base
{
    protected $attributesDefinitions = [
        'documentType' => 'string',
        'content' => 'base64',
        'url' => 'string',
        'name' => 'string',
        'checkBoxTexts' => 'array',
        'metaData' => 'array',
        'signatureFields' => 'array',
        'SEPAData' => 'Globalis\Universign\Request\SEPAData',
    ];

    protected function extractParamNameFromSetter($method)
    {
        if (preg_match('/SEPA/', $method)) {
            return substr($method, 3);
        }
        return parent::extractParamNameFromSetter($method);
    }

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
