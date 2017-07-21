<?php

namespace Globalis\Universign\Request;

class TransactionRequest extends Base
{
    // Handwritten Modes
    const HANDWRITTEN_SIGNATURE_MODE_NONE = 0;

    const HANDWRITTEN_SIGNATURE_MODE_BASIC = 1;

    const HANDWRITTEN_SIGNATURE_MODE_DIGITAL = 2;

    // Chaining Modes
    const CHAINING_MODE_NONE = 'none';

    const CHAINING_MODE_EMAIL = 'email';

    const CHAINING_MODE_WEB = 'web';


    protected $attributesDefinitions = [
        'profile' => 'string',
        'customId' => 'string',
        'mustContactFirstSigner' => 'bool',
        'finalDocRequesterSent' => 'bool',
        'finalDocSent' => 'bool',
        'finalDocObserverSent' => 'bool',
        'description' => 'string',
        'certificateType' => 'string',
        'language' => 'string',
        'handwrittenSignatureMode' => 'int',
        'chainingMode' => 'string',
        'signers' => 'array',
        'documents' => 'array',
    ];

    public function addSigner(TransactionSigner $signer)
    {
        $this->attributes['signers'][] = $signer;
        return $this;
    }

    public function addDocument(TransactionDocument $document)
    {
        $this->attributes['documents'][] = $document;
        return $this;
    }
}
