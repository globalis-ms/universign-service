<?php

namespace Globalis\Universign\Response;

use PhpXmlRpc\Value;

class CertificateInfo extends Base
{
    protected $attributesDefinitions = [
        /**
         * The certificate subject DN
         */
        'subject' => true,
        /**
         * The certificate issuer DN
         */
        'issuer' => true,
        /**
         * The certificate serial number
         */
        'serial' => true,
    ];
}
