<?php
include_once dirname(__FILE__) . '/../../common/Environment.php';
include_once dirname(__FILE__) . '/../TestUtils.php';
include_once dirname(__FILE__) . '/../../services/restaurants/services/CountriesLocalFavoritesService.php';


class CountriesLocalFavoritesServiceTest extends \PHPUnit_Framework_TestCase {

    private $testUtils;
    private $service;

    public function setUp()
    {
        $this->testUtils = new TestUtils(Environment::SANDBOX);
        $this->service = new CountriesLocalFavoritesService(
            TestUtils::SANDBOX_CONSUMER_KEY,
            $this->testUtils->getPrivateKey(),
            Environment::SANDBOX
        );
    }

    public function testRestaurantCountries()
    {
        $countries = $this->service->getCountries();
        $this->assertTrue(count($countries->getCountry()) > 0);
    }
}
 