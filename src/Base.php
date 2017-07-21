<?php

namespace Globalis\Universign;

use PhpXmlRpc\Client;
use PhpXmlRpc\Request;
use PhpXmlRpc\Value;
use RuntimeException;

class Base
{
    /**
     * Xml Rpc Client
     *
     * @var \PhpXmlRpc;
     */
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->client->return_type = 'xmlrpcvals';
    }

    protected function buildRequest($method, $data)
    {
        if (!is_array($data)) {
            $data = [$data];
        }

        return new Request(
            $method,
            $data
        );
    }

    protected function sendRequest($method, $data)
    {
        $response = $this->client->send(
            $this->buildRequest($method, $data)
        );

        if (!$response->faultCode()) {
            return $response->value();
        }
        throw new RuntimeException(
            sprintf(
                'Unsuccessful request: `%s` resulted in a `%s %s` response',
                $method,
                $response->faultCode(),
                $response->faultString()
            )
        );
    }
}
