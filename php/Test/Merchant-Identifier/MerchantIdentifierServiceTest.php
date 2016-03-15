<?php

require_once('../../common/Environment.php');
require_once('../../services/Merchant-Identifier/MerchantIdentifierService.php');
require_once('../../services/Merchant-Identifier/domain/MerchantIdentifierRequestOptions.php');
require_once('../../services/Merchant-Identifier/domain/MerchantIds.class.php');
require_once('../../services/Merchant-Identifier/domain/ReturnedMerchants.class.php');
require_once('../TestUtils.php');

class MerchantIdentifierServiceTest extends PHPUnit_Framework_TestCase {

    private $merchantIdentifierService;

    public function setUp() {
        $testUtils = new TestUtils(Environment::SANDBOX);
        $this->merchantIdentifierService = new MerchantIdentifierService(TestUtils::SANDBOX_CONSUMER_KEY, $testUtils->getPrivateKey(), Environment::SANDBOX);
    }

    public function testMerchantIdentifierServiceByMerchantId_ExactMatch() {
        $options = new MerchantIdentifierRequestOptions("DIRECTSATELLITETV");
        $options->setType("ExactMatch");
        $merchantIds = $this->merchantIdentifierService->getMerchantIds($options);
        $this->assertTrue(count($merchantIds->getReturnedMerchants()) > 0);
    }

    public function testMerchantIdentifierServiceByMerchantId_FuzzyMatch() {
        $options = new MerchantIdentifierRequestOptions("DIRECTSATELLITETV");
        $options->setType("FuzzyMatch");
        $merchantIds = $this->merchantIdentifierService->getMerchantIds($options);
        $this->assertTrue(count($merchantIds->getReturnedMerchants()->getMerchant()) > 0);
    }

//    public function testMerchantIdentifierServiceByMerchantId_DESCRIPTOR_TOO_SMALL() {
//        $options = new MerchantIdentifierRequestOptions("BESTBUY");
//        $merchant = $this->merchantIdentifierService->getMerchantIds($options);
//        //$this->assertTrue(count($merchant->getReturnedMerchants()) > 0);
//    }
}