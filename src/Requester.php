<?php

namespace Globalis\Universign;

use Globalis\Universign\Response\TransactionDocument;
use Globalis\Universign\Response\TransactionInfo;
use Globalis\Universign\Request\TransactionRequest;
use Globalis\Universign\Response\TransactionResponse;
use PhpXmlRpc\Value;

class Requester extends Base
{
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
            new Value($customerId, 'string')
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
                'requester.getTransactionInfoByCustomId',
                new Value($customerId, 'string')
            )
        );
    }

    /**
     * Cancel a transaction in progress with this id.
     *
     * @param   string  $transactionId
     * @return  TransactionInfo
     */
    public function cancelTransaction($transactionId)
    {
        return new TransactionInfo(
            $this->sendRequest(
                'requester.cancelTransaction',
                new Value($transactionId, 'string')
            )
        );
    }
}
