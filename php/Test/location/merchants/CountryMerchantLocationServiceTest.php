<?php
require_once('../../../common/Environment.php');
require_once('../../../services/location/merchants/CountryMerchantLocationService.php');
require_once('../../TestUtils.php');
require_once('../../../services/location/domain/options/merchants/CountryMerchantLocationRequestOptions.php');
require_once('../../../services/location/domain/options/merchants/Details.php');


class CountryMerchantLocationServiceTest extends \PHPUnit_Framework_TestCase {

    private $testUtils;
    private $service;

    public function setUp()
    {
        $this->testUtils = new TestUtils(Environment::SANDBOX);
        $this->service = new CountryMerchantLocationService(
            TestUtils::SANDBOX_CONSUMER_KEY,
            $this->testUtils->getPrivateKey(),
            Environment::SANDBOX
        );
    }

    public function testService()
    {
        $options = new CountryMerchantLocationRequestOptions(Details::FEATURES_CASHBACK);
        $countries = $this->service->getCountries($options);
        $this->assertTrue(count($countries->getCountry()) > 0);
    }
}
 