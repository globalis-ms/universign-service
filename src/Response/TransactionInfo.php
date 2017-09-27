<?php

namespace Globalis\Universign\Response;

use PhpXmlRpc\Value;

class TransactionInfo extends Base
{

    const STATUS_READY = 'ready';
    const STATUS_EXPIRED = 'expired';
    const STATUS_CANCELED = 'canceled';
    const STATUS_FAILED = 'failed';
    const STATUS_COMPLETED = 'completed';

    protected $attributesDefinitions = [
        /**
         * The status of the transaction
         */
        'status' => true,
        /**
         * A list of bean containing information about the signers
         * and their progression in the signature process.
         */
        'signerInfos' => 'parseSignerInfos',
        /**
         * The index of current signer if the status of transaction
         * is ready or who ended the transactions for other status.
         */
        'currentSigner' => true,
        /**
         * The creation date or last relaunch date of this transaction.
         */
        'creationDate' => true,
        /**
         * The description of the Transaction.
         */
        'description' => true,
        /**
         * A bean containing information about the requester of a transaction
         */
        'initiatorInfo' => 'parseInitiatorInfo',
        /**
         * Whether the transaction was requested with requesting
         * handwritten signature for each signature field or not.
         */
        'eachField' => true,
        /**
         * This id can be specified when creating the transaction request
         * and is used as additional information to identify the transaction.
         */
        'customId' => true,
        /**
         * This id is generated when creating the transaction request
         * and is the unique identifier of this transaction.
         */
        'transactionId' => true,
    ];

    protected function parseSignerInfos(Value $value)
    {
        $data = [];
        foreach ($value as $signer) {
            $data[] = new SignerInfo($signer);
        }
        return $data;
    }

    protected function parseInitiatorInfo(Value $value)
    {
        return new InitiatorInfo($value);
    }
}
