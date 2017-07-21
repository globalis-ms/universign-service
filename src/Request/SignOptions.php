<?php

namespace Globalis\Universign\Request;

class SignOptions extends Base
{
    const SIGNATURE_FORMAT_PADES = 'PADES';
    const SIGNATURE_FORMAT_PADES_COMP = 'PADES-COMP';
    const SIGNATURE_FORMAT_ISO320001 = 'ISO-32000-1';

    protected $attributesDefinitions = [
        'profile' => 'string',
        'signatureField' => 'Globalis\Universign\Request\SignatureField',
        'reason' => 'string',
        'location' => 'string',
        'signatureFormat' => 'string',
        'language' => 'string',
        'patternName' => 'string',
    ];
}
