<?php

include_once dirname(__FILE__) . '/../../common/Environment.php';
include_once dirname(__FILE__) . '/../TestUtils.php';
include_once dirname(__FILE__) . '/../../services/MoneySend/services/TransferReversalService.php';
include_once dirname(__FILE__) . '/../../services/MoneySend/domain/TransferReversal.php';
include_once dirname(__FILE__) . '/../../services/MoneySend/domain/TransferReversalRequest.php';

class TransferReversalServiceTest extends \PHPUnit_Framework_TestCase {

    private $transferReversalService;
    private $transferReversalRequest;
    private $transferReversal;

    public function setUp() {
        $testUtils = new TestUtils(Environment::SANDBOX);
        $this->transferReversalService = new TransferReversalService(TestUtils::SANDBOX_CONSUMER_KEY, $testUtils->getPrivateKey(), Environment::SANDBOX);
    }

    public function testTransferReversalService() {
        $this->transferReversalRequest = new TransferReversalRequest();
        $this->transferReversalRequest->setICA("009674");
        $this->transferReversalRequest->setTransactionReference("4000000001111111113");
        $this->transferReversalRequest->setReversalReason("FAILURE IN PROCESSING");
        $this->transferReversal = $this->transferReversalService->getTransferReversal($this->transferReversalRequest);
        $this->assertTrue($this->transferReversal != null);
        $this->assertTrue($this->transferReversal->getTransactionReference() > 0);
        $this->assertTrue($this->transferReversal->getTransactionHistory() != null);
        $this->assertTrue($this->transferReversal->getTransactionHistory()->getTransaction()->getResponse()->getCode() == 00);
    }

}