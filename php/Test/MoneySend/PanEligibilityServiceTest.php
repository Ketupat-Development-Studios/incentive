<?php

include_once dirname(__FILE__) . '/../../common/Environment.php';
include_once dirname(__FILE__) . '/../TestUtils.php';
include_once dirname(__FILE__) . '/../../services/MoneySend/services/PanEligibilityService.php';
include_once dirname(__FILE__) . '/../../services/MoneySend/domain/PanEligibility.php';
include_once dirname(__FILE__) . '/../../services/MoneySend/domain/PanEligibilityRequest.php';

class PanEligibilityServiceTest extends \PHPUnit_Framework_TestCase {

    private $panEligibilityService;
    private $panEligibilityRequest;
    private $panEligibility;

    public function setUp() {
        $testUtils = new TestUtils(Environment::SANDBOX);
        $this->panEligibilityService = new PanEligibilityService(TestUtils::SANDBOX_CONSUMER_KEY, $testUtils->getPrivateKey(), Environment::SANDBOX);
    }

    public function testPanEligibilityService_NotEligible() {
        $this->panEligibilityRequest = new PanEligibilityRequest();
        $this->panEligibilityRequest->setSendingAccountNumber("5184680990000024");
        $this->panEligibilityRequest->setReceivingAccountNumber("5184680060000201");
        $this->panEligibility = $this->panEligibilityService->getPanEligibility($this->panEligibilityRequest);
        $this->assertTrue($this->panEligibility->getRequestId() != null && $this->panEligibility->getRequestId() > 0);
        $this->assertTrue($this->panEligibility->getSendingEligibility()->getEligible() != null && $this->panEligibility->getSendingEligibility()->getEligible() == "false");
        $this->assertTrue($this->panEligibility->getReceivingEligibility()->getEligible() != null && $this->panEligibility->getReceivingEligibility()->getEligible() == "false");
    }

    public function testPanEligibilityService_SendingEligible() {
        $this->panEligibilityRequest = new PanEligibilityRequest();
        $this->panEligibilityRequest->setSendingAccountNumber("5184680430000006");
        $this->panEligibility = $this->panEligibilityService->getPanEligibility($this->panEligibilityRequest);
        $this->assertTrue($this->panEligibility->getRequestId() != null && $this->panEligibility->getRequestId() > 0);
        $this->assertTrue($this->panEligibility->getSendingEligibility()->getEligible() != null && $this->panEligibility->getSendingEligibility()->getEligible() == "true");
        $this->assertTrue($this->panEligibility->getSendingEligibility()->getAccountNumber() != null && strlen($this->panEligibility->getSendingEligibility()->getAccountNumber()) > 1);
    }

    public function testPanEligibilityService_ReceivingEligible() {
        $this->panEligibilityRequest = new PanEligibilityRequest();
        $this->panEligibilityRequest->setReceivingAccountNumber("5184680430000006");
        $this->panEligibility = $this->panEligibilityService->getPanEligibility($this->panEligibilityRequest);
        $this->assertTrue($this->panEligibility->getRequestId() != null && $this->panEligibility->getRequestId() > 0);
        $this->assertTrue($this->panEligibility->getReceivingEligibility()->getEligible() != null && $this->panEligibility->getReceivingEligibility()->getEligible() == "true");
        $this->assertTrue($this->panEligibility->getReceivingEligibility()->getAccountNumber() != null && strlen($this->panEligibility->getReceivingEligibility()->getAccountNumber()) > 1);
    }

}