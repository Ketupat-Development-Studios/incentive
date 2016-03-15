<?php
require_once('../../../common/Environment.php');
require_once('../../../services/location/atms/CountryAtmLocationService.php');
require_once('../../TestUtils.php');


class CountryAtmLocationServiceTest extends \PHPUnit_Framework_TestCase {

    private $testUtils;
    private $service;

    public function setUp()
    {
        $this->testUtils = new TestUtils(Environment::SANDBOX);
        $this->service = new CountryAtmLocationService(
            TestUtils::SANDBOX_CONSUMER_KEY,
            $this->testUtils->getPrivateKey(),
            Environment::SANDBOX
        );
    }

    public function testService()
    {
        $countries = $this->service->getCountries();
        $this->assertTrue(count($countries->getCountry()) > 0);
    }

}
 