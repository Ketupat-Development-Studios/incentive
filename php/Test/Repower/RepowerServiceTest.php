<?php

require_once '../../services/Repower/Repower/RepowerService.php';
require_once '../../services/Repower/RepowerReversal/RepowerReversalService.php';
require_once '../../services/Repower/Repower/domain/RepowerRequest.php';
require_once '../../services/Repower/Repower/domain/Repower.php';
require_once '../../services/Repower/Repower/domain/TransactionHistory.php';
require_once '../../services/Repower/Repower/domain/Transaction.php';
require_once '../../services/Repower/Repower/domain/Response.php';
require_once '../../services/Repower/Repower/domain/AccountBalance.php';
require_once '../../services/Repower/RepowerReversal/domain/RepowerReversal.php';
require_once '../../services/Repower/RepowerReversal/domain/RepowerReversalRequest.php';
include_once('../TestUtils.php');

class RepowerServiceTest extends PHPUnit_Framework_TestCase
{
	private $repowerService;
	private $repowerReversalService;
	private $repowerRequest;
	private $repowerReversalRequest;
	
	public function setUp()
	{
        $testUtils = new TestUtils(Environment::SANDBOX);
        $this->repowerService = new RepowerService(TestUtils::SANDBOX_CONSUMER_KEY,$testUtils->getPrivateKey(),Environment::SANDBOX);
		$this->repowerReversalService = new RepowerReversalService(TestUtils::SANDBOX_CONSUMER_KEY,$testUtils->getPrivateKey(),Environment::SANDBOX);
        $this->repowerRequest = new RepowerRequest();
        $this->repowerReversalRequest = new RepowerReversalRequest();
        $this->repowerRequest->setTransactionAmount(new TransactionAmount());
        $this->repowerRequest->setCardAcceptor(new CardAcceptor());
	}
	
	public function testRepowerService()
    {
        $referenceNbr = self::generateRandomNumber();

        //load
        $this->repowerRequest->setTransactionReference($referenceNbr);
        $this->repowerRequest->setCardNumber(number_format(5184680430000006,0,'',''));
        $this->repowerRequest->getTransactionAmount()->setValue(30000);
        $this->repowerRequest->getTransactionAmount()->setCurrency("840");
        $this->repowerRequest->setLocalDate("1230");
        $this->repowerRequest->setLocalTime("092435");
        $this->repowerRequest->setChannel("W");
        $this->repowerRequest->setICA("009674");
        $this->repowerRequest->setProcessorId(9000000442);
        $this->repowerRequest->setRoutingAndTransitNumber(990442082);
        $this->repowerRequest->setMerchantType("6532");
        $this->repowerRequest->getCardAcceptor()->setName("Prepaid Load Store");
        $this->repowerRequest->getCardAcceptor()->setCity("St Charles");
        $this->repowerRequest->getCardAcceptor()->setState("MO");
        $this->repowerRequest->getCardAcceptor()->setPostalCode("63301");
        $this->repowerRequest->getCardAcceptor()->setCountry("USA");

        $this->repowerService->getRepower($this->repowerRequest);

        //reverse load
        $this->repowerReversalRequest->setReversalReason("UNIT TEST");
        $this->repowerReversalRequest->setTransactionReference($referenceNbr);
        $this->repowerReversalRequest->setICA("009674");

        $reversal = $this->repowerReversalService->getRepowerReversal($this->repowerReversalRequest);
        $reversal2 = $this->repowerReversalService->getRepowerReversal($this->repowerReversalRequest);

        $this->assertEquals($reversal->getTransactionHistory()->getTransaction()->getSettlementDate(),$reversal2->getTransactionHistory()->getTransaction()->getSettlementDate());
        $this->assertEquals($reversal->getTransactionHistory()->getTransaction()->getType(),$reversal2->getTransactionHistory()->getTransaction()->getType());
        $this->assertEquals($reversal->getTransactionHistory()->getTransaction()->getNetworkReferenceNumber(),$reversal2->getTransactionHistory()->getTransaction()->getNetworkReferenceNumber());
        $this->assertEquals($reversal->getTransactionHistory()->getTransaction()->getResponse(),$reversal2->getTransactionHistory()->getTransaction()->getResponse());
        $this->assertEquals($reversal->getTransactionHistory()->getTransaction()->getSubmitDateTime(),$reversal2->getTransactionHistory()->getTransaction()->getSubmitDateTime());
        $this->assertEquals($reversal->getTransactionHistory()->getTransaction()->getSystemTraceAuditNumber(),$reversal2->getTransactionHistory()->getTransaction()->getSystemTraceAuditNumber());
    }

    //Prefered method of RandomNumberGeneration was returning scientific notation
    private function generateRandomNumber(){
        $i = 0;
        $tmp = mt_rand(1,9);
        do {
            $tmp .= mt_rand(0, 9);
        } while(++$i < 18);
        return $tmp;
    }
}