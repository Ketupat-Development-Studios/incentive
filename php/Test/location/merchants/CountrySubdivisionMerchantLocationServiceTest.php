<?php
require_once('../../../common/Environment.php');
require_once('../../../services/location/merchants/CountrySubdivisionMerchantLocationService.php');
require_once('../../TestUtils.php');
require_once('../../../services/location/domain/options/merchants/Details.php');
require_once('../../../services/location/domain/options/merchants/CountrySubdivisionMerchantLocationRequestOptions.php');


class CountrySubdivisionMerchantLocationServiceTest extends \PHPUnit_Framework_TestCase {

    private $testUtils;
    private $service;

    public function setUp()
    {
        $this->testUtils = new TestUtils(Environment::SANDBOX);
        $this->service = new CountrySubdivisionMerchantLocationService(
            TestUtils::SANDBOX_CONSUMER_KEY,
            $this->testUtils->getPrivateKey(),
            Environment::SANDBOX
        );
    }

    public function testCountrySubdivisionMerchantLocationServiceWithPaypass()
    {
        $options = new CountrySubdivisionMerchantLocationRequestOptions(
            Details::ACCEPTANCE_PAYPASS,
            "USA"
        );
        $countrySubdivisions = $this->service->getCountrySubdivisions($options);
        $this->assertTrue(count($countrySubdivisions->getCountrySubdivision()) > 0);
    }

    public function testCountrySubdivisionMerchantLocationServiceWithOffers()
    {
        $options = new CountrySubdivisionMerchantLocationRequestOptions(
            Details::OFFERS_EASYSAVINGS,
            "USA"
        );
        $countrySubdivisions = $this->service->getCountrySubdivisions($options);
        $this->assertTrue(count($countrySubdivisions->getCountrySubdivision()) > 0);
    }

    public function testCountrySubdivisionMerchantLocationServiceWithPrepaidTravelCard()
    {
        $options = new CountrySubdivisionMerchantLocationRequestOptions(
            Details::PRODUCTS_PREPAID_TRAVEL_CARD,
            "USA"
        );
        $countrySubdivisions = $this->service->getCountrySubdivisions($options);
        $this->assertTrue(count($countrySubdivisions->getCountrySubdivision()) > 0);
    }

    public function testCountrySubdivisionMerchantLocationServiceWithRepower()
    {
        $options = new CountrySubdivisionMerchantLocationRequestOptions(
            Details::TOPUP_REPOWER,
            "USA"
        );
        $countrySubdivisions = $this->service->getCountrySubdivisions($options);
        $this->assertTrue(count($countrySubdivisions->getCountrySubdivision()) > 0);
    }

    public function testCountrySubdivisionMerchantLocationServiceWithCashback()
    {
        $options = new CountrySubdivisionMerchantLocationRequestOptions(
            Details::FEATURES_CASHBACK,
            "USA"
        );
        $countrySubdivisions = $this->service->getCountrySubdivisions($options);
        $this->assertTrue(count($countrySubdivisions->getCountrySubdivision()) > 0);
    }



}
 