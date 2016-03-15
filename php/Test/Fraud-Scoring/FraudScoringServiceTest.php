<?php

require_once '../../services/Fraud-Scoring/domain/ScoreLookupRequest.php';
require_once '../../services/Fraud-Scoring/domain/TransactionDetail.php';
require_once '../../services/Fraud-Scoring/domain/ScoreLookup.php';
require_once '../../services/Fraud-Scoring/domain/TransactionDetail.php';
require_once '../../services/Fraud-Scoring/domain/ScoreResponse.php';
require_once '../../services/Fraud-Scoring/FraudScoringService.php';
require_once '../TestUtils.php';
require_once 'MatchIndicatorStatus.php';

class FraudScoringServiceTest extends PHPUnit_Framework_TestCase {

    private $fraudScoringService;
    private $scoreLookupRequest;

    public function setUp(){
        $testUtils = new TestUtils(Environment::SANDBOX);

        $this->fraudScoringService = new FraudScoringService(TestUtils::SANDBOX_CONSUMER_KEY, $testUtils->getPrivateKey(), Environment::SANDBOX);
        $this->scoreLookupRequest = new ScoreLookupRequest();
        $this->scoreLookupRequest->setTransactionDetail(new TransactionDetail());

        $this->scoreLookupRequest->getTransactionDetail()->setCustomerIdentifier(1996);
        $this->scoreLookupRequest->getTransactionDetail()->setMerchantIdentifier(123);
        $this->scoreLookupRequest->getTransactionDetail()->setAccountNumber("5555555555555555555");
        $this->scoreLookupRequest->getTransactionDetail()->setAccountPrefix(555555);
        $this->scoreLookupRequest->getTransactionDetail()->setAccountSuffix(5555);
        $this->scoreLookupRequest->getTransactionDetail()->setTransactionDate(1231);
        $this->scoreLookupRequest->getTransactionDetail()->setTransactionTime("035959");
        $this->scoreLookupRequest->getTransactionDetail()->setBankNetReferenceNumber("abcABC123");
        $this->scoreLookupRequest->getTransactionDetail()->setStan(123456);
    }

    public function testLowFraudScoringSingleTransactionMatch(){
        $this->scoreLookupRequest->getTransactionDetail()->setTransactionAmount(62500);
        $scoreLookup = $this->fraudScoringService->getScoreLookup($this->scoreLookupRequest);
        $this->assertTrue($scoreLookup->getScoreResponse()->getMatchIndicator() == MatchIndicatorStatus::SINGLE_TRANSACTION_MATCH);
    }

    public function testMidFraudScoringSingleTransactionMatch(){
        $this->scoreLookupRequest->getTransactionDetail()->setTransactionAmount(10001);
        $scoreLookup = $this->fraudScoringService->getScoreLookup($this->scoreLookupRequest);
        $this->assertTrue($scoreLookup->getScoreResponse()->getMatchIndicator() == MatchIndicatorStatus::MULTIPLE_TRANS_IDENTICAL_CARD_MATCH);
    }

    public function testHighFraudScoringSingleTransactionMatch(){
        $this->scoreLookupRequest->getTransactionDetail()->setTransactionAmount(20001);
        $scoreLookup = $this->fraudScoringService->getScoreLookup($this->scoreLookupRequest);
        $this->assertTrue($scoreLookup->getScoreResponse()->getMatchIndicator() == MatchIndicatorStatus::MULTIPLE_TRANS_DIFFERING_CARDS_MATCH);
    }

    public function testNoMatchFound(){
        $this->scoreLookupRequest->getTransactionDetail()->setTransactionAmount(30001);
        $scoreLookup = $this->fraudScoringService->getScoreLookup($this->scoreLookupRequest);
        $this->assertTrue($scoreLookup->getScoreResponse()->getMatchIndicator() == MatchIndicatorStatus::NO_MATCH_FOUND);
    }

    /**
     * @expectedException    Exception
     */
    public function testSystemError(){
        $this->scoreLookupRequest->getTransactionDetail()->setTransactionAmount(50001);
        $this->fraudScoringService->getScoreLookup($this->scoreLookupRequest);
    }
}
