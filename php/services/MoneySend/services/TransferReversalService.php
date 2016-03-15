<?php

include_once dirname(__FILE__) . '/../../../common/Connector.php';
include_once dirname(__FILE__) . '/../../../common/Environment.php';
include_once dirname(__FILE__) . '/../../../common/Serializer.php';
include_once dirname(__FILE__) . '/../domain/TransferReversal.php';
include_once dirname(__FILE__) . '/../domain/TransferReversalRequest.php';
include_once dirname(__FILE__) . '/../domain/TransactionHistory.php';
include_once dirname(__FILE__) . '/../domain/Transaction.php';
include_once dirname(__FILE__) . '/../domain/Response.php';

class TransferReversalService extends Connector {
    private $environment;
    const SANDBOX_URL = "https://sandbox.api.mastercard.com/moneysend/v2/transferreversal?Format=XML";
    const PRODUCTION_URL = "https://api.mastercard.com/moneysend/v2/transferreversal?Format=XML";
    private $transferReversalRequest;
    private $transferReversal;

    public function __construct($consumerKey, $privateKey, $environment) {
        parent::__construct($consumerKey, $privateKey);
        $this->environment = $environment;
    }

    public function getTransferReversal(TransferReversalRequest $request) {
        $response = $this->doSimpleRequest($this->getURL(),Connector::POST, $this->generateTransferReversalXML($request));
        $xml = simplexml_load_string($response);
        return $this->buildTransferReversal($xml);
    }

    private function getURL() {
        if($this->environment == Environment::PRODUCTION){
            return TransferReversalService::PRODUCTION_URL;
        }
        else{
            return TransferReversalService::SANDBOX_URL;
        }
    }

    private function generateTransferReversalXML(TransferReversalRequest $request) {
        $xml= null;

        $xml  = "<TransferReversalRequest>";
        $xml .=         "<ICA>".$request->getICA()."</ICA>";
        $xml .=         "<TransactionReference>".$request->getTransactionReference()."</TransactionReference>";
        $xml .=         "<ReversalReason>".$request->getReversalReason()."</ReversalReason>";
        $xml .= "</TransferReversalRequest>";

        return $xml;
    }

    private function buildTransferReversal($xml) {
        $transferReversal = new TransferReversal();
        $transferReversal->setRequestId((string)$xml->RequestId);
        $transferReversal->setOriginalRequestId((string)$xml->OriginalRequestId);
        $transferReversal->setTransactionReference((string)$xml->TransactionReference);

        $transactionHistory = new TransactionHistory();
        $tmpTransaction = new Transaction();
        $transaction = $xml->TransactionHistory->Transaction;
        $tmpTransaction->setType((string)$transaction->Type);
        $tmpTransaction->setSystemTraceAuditNumber((string)$transaction->SystemTraceAuditNumber);
        $tmpTransaction->setNetworkReferenceNumber((string)$transaction->NetworkReferenceNumber);
        $tmpTransaction->setSettlementDate((string)$transaction->SettlementDate);

        $tmpResponse = new Response();
        $response = $transaction->Response;
        $tmpResponse->setCode((string)$response->Code);
        $tmpResponse->setDescription((string)$response->Description);

        $tmpTransaction->setSubmitDateTime((string)$transaction->SubmitDateTime);

        $tmpTransaction->setResponse($tmpResponse);

        $transactionHistory->setTransaction($tmpTransaction);
        $transferReversal->setTransactionHistory($transactionHistory);

        return $transferReversal;
    }

}