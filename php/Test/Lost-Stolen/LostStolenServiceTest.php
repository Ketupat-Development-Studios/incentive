<?php

include_once('../../services/Lost-Stolen/domain/Account.php');
include_once('../../services/Lost-Stolen/domain/AccountInquiry.php');
include_once('../../services/Lost-Stolen/LostStolenService.php');
include_once('../../common/Environment.php');
include_once('../TestUtils.php');

class LostStolenServiceTest extends PHPUnit_Framework_TestCase
{
    private $LostStolenService;
    private $account;

    public function setUp(){
        $testUtils = new TestUtils(Environment::SANDBOX);
        $this->LostStolenService = new LostStolenService(TestUtils::SANDBOX_CONSUMER_KEY, $testUtils->getPrivateKey(), Environment::SANDBOX);
        $this->account = new Account();
    }

    public function testStolen(){
        $this->account = new Account();
        $this->account = $this->LostStolenService->getLostStolen("5343434343434343");
        $this->assertEquals(true,$this->account->getReasonCode() == "S");
    }

    public function testFraud(){
        $this->account = new Account();
        $this->account = $this->LostStolenService->getLostStolen("5105105105105100");
        $this->assertEquals(true,$this->account->getReasonCode() == "F");
    }

    public function testLost(){
        $this->account = new Account();
        $this->account = $this->LostStolenService->getLostStolen("5222222222222200");
        $this->assertEquals(true,$this->account->getReasonCode() == "L");
    }

    public function testCaptureCard(){
        $this->account = new Account();
        $this->account = $this->LostStolenService->getLostStolen("5305305305305300");
        $this->assertEquals(true,$this->account->getReasonCode() == "P");
    }

    public function testUnauthorizedUse(){
        $this->account = new Account();
        $this->account = $this->LostStolenService->getLostStolen("6011111111111117");
        $this->assertEquals(true,$this->account->getReasonCode() == "U");
    }

    public function testCounterfeit(){
        $this->account = new Account();
        $this->account = $this->LostStolenService->getLostStolen("4444333322221111");
        $this->assertEquals(true,$this->account->getReasonCode() == "X");
    }

    public function testNotListed(){
        $this->account = new Account();
        $this->account = $this->LostStolenService->getLostStolen("343434343434343");
        $this->assertEquals(true,$this->account->getReasonCode()== "");
    }

}
 