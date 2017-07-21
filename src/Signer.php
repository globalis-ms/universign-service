<?php

namespace Globalis\Universign;

use Globalis\Universign\Request\SignOptions;
use PhpXmlRpc\Value;

class Signer extends Base
{
    /**
     * Signs a document, using the default signature profile and options.
     *
     * @param   byte $document
     * @param   SignOptions $options
     * @return  void
     */
    public function sign($document, SignOptions $options = null)
    {
        if ($options) {
            return $this->signWithOptions($document, $options);
        }

        return $this->sendRequest(
            'signer.sign',
            new Value($document, 'base64')
        );
    }

    /**
     * Signs a document, using a set of options.
     *
     * @param   byte $document
     * @param   SignOptions $options
     * @return  void
     */
    public function signWithOptions($document, SignOptions $options)
    {
        return $this->sendRequest(
            'signer.signWithOptions',
            [
                new Value($document, 'base64'),
                $options->buildRpcValues()
            ]
        );
    }
}
