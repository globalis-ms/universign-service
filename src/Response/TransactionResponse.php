<?php

namespace Globalis\Universign\Response;

use PhpXmlRpc\Value;

class TransactionResponse
{
    protected $attributesDefinitions = [
        /**
         * This transaction id.
         */
        'id' => true,
        /**
         * The URL to the web interface for the first signer.
         */
        'url' => true,
    ];
}
