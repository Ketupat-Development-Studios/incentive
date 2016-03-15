<?php
include_once dirname(__FILE__) . '/../../common/Environment.php';
include_once dirname(__FILE__) . '/../../services/restaurants/domain/options/CountrySubdivisionsLocalFavoritesRequestOptions.php';
include_once dirname(__FILE__) . '/../TestUtils.php';
include_once dirname(__FILE__) . '/../../services/restaurants/services/CountrySubdivisionsLocalFavoritesService.php';


class CountrySubdivisionsLocalFavoritesServiceTest extends \PHPUnit_Framework_TestCase {

    private $testUtils;
    private $service;

    public function setUp()
    {
        $this->testUtils = new TestUtils(Environment::SANDBOX);
        $this->service = new CountrySubdivisionsLocalFavoritesService(
            TestUtils::SANDBOX_CONSUMER_KEY,
            $this->testUtils->getPrivateKey(),
            Environment::SANDBOX
        );
    }

    public function testCountrySubdivisionService()
    {
        $options = new CountrySubdivisionsLocalFavoritesRequestOptions("USA");
        $countrySubdivisions = $this->service->getCountrySubdivisions($options);
        $this->assertTrue(count($countrySubdivisions->getCountrySubdivision()) > 0);
    }

}
 