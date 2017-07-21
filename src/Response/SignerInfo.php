<?php

namespace Globalis\Universign\Response;

use PhpXmlRpc\Value;

class SignerInfo extends Base
{

    const STATUS_WAITING = 'waiting';
    const STATUS_READY = 'ready';
    const STATUS_ACCESSED = 'accessed';
    const STATUS_CODE = 'code-sent';
    const STATUS_SIGNED = 'signed';
    const STATUS_PENDING_ID_DOCS = 'pending-id-docs';
    const STATUS_PENDING_VALIDATION = 'pending-validation';
    const STATUS_CANCELED = 'canceled';
    const STATUS_FAILED = 'failed';


    protected $attributesDefinitions = [
        /**
         * The status of the signer.
         */
        'status' => true,
        /**
         * The URL to the web interface for the first signer.
         */
        'error' => true,

        'certificateInfo' => 'parseCertificateInfo',

        'url' => true,

        'email' => true,

        'firstName' => true,

        'lastName' => true,

        'actionDate' => true,

        'refusedDocs' => true,
    ];

    protected function parseCertificateInfo(Value $value)
    {
        $data = [];
        foreach ($value as $signer) {
            $data[] = new CertificateInfo($signer);
        }
        return $data;
    }
}
