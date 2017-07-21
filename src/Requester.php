<?php

namespace Globalis\Universign;

use Globalis\Universign\Response\TransactionDocument;
use Globalis\Universign\Response\TransactionInfo;
use Globalis\Universign\Request\TransactionRequest;
use Globalis\Universign\Response\TransactionResponse;
use PhpXmlRpc\Client;
use PhpXmlRpc\Request;
use PhpXmlRpc\Value;
use RuntimeException;

class Requester
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

    /**
     * Requests a new transaction for the client signature service.
     *
     * Sends the document to be signed and other parameters and returns an URL where the end
     * user should be redirected to. A transaction must be completed whithin 14
     * days after its request.
     *
     * @param   \Globalis\Universign\Request\TransactionRequest  $request
     * @return  \Globalis\Universign\Response\TransactionResponse
     */
    public function requestTransaction(TransactionRequest $request)
    {
        return new TransactionResponse(
            $this->sendRequest(
                'requester.requestTransaction',
                $request->buildRpcValues()
            )
        );
    }

    /**
     * Requests signed documents (after their transaction is completed) by their transaction id.
     *
     * @param   string  $transactionId
     * @return  array
     */
    public function getDocuments($transactionId)
    {
        $data = [];
        $values = $this->sendRequest(
            'requester.getDocuments',
            new Value($transactionId, 'string')
        );

        foreach ($values as $key => $value) {
            $data[] = new TransactionDocument($value);
        }

        return $data;
    }

    /**
     * Requests signed documents (after their transaction is finished) by their custom id.
     *
     * @param   string  $customerId
     * @return  array
     */
    public function getDocumentsByCustomId($customerId)
    {
        $data = [];
        $values = $this->sendRequest(
            'requester.getDocumentsByCustomId',
            new Value($transactionId, 'string')
        );

        foreach ($values as $key => $value) {
            $data[] = new TransactionDocument($value);
        }

        return $data;
    }

    /**
     * Requests information about the status of the transaction with this id.
     *
     * @param   string  $transactionId
     * @return  TransactionInfo
     */
    public function getTransactionInfo($transactionId)
    {
        return new TransactionInfo(
            $this->sendRequest(
                'requester.getTransactionInfo',
                new Value($transactionId, 'string')
            )
        );
    }

    /**
     * Requests information about the status of the transaction with this id.
     *
     * @param   string  $customerId
     * @return  TransactionInfo
     */
    public function getTransactionInfoByCustomId($customerId)
    {
        return new TransactionInfo(
            $this->sendRequest(
                'requester.getTransactionInfo',
                new Value($customerId, 'string')
            )
        );
    }

    protected function buildRequest($method, Value $data)
    {
        return new Request(
            $method,
            [
                $data
            ]
        );
    }

    protected function sendRequest($method, Value $data)
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
