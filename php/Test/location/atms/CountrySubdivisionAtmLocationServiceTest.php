<?php
require_once('../../../common/Environment.php');
require_once('../../../services/location/atms/CountrySubdivisionAtmLocationService.php');
require_once('../../../services/location/domain/options/atms/CountrySubdivisionAtmLocationRequestOptions.php');
require_once('../../TestUtils.php');


class CountrySubdivisionAtmLocationServiceTest extends \PHPUnit_Framework_TestCase {

    private $testUtils;
    private $service;

    public function setUp()
    {
        $this->testUtils = new TestUtils(Environment::SANDBOX);
        $this->service = new CountrySubdivisionAtmLocationService(
            TestUtils::SANDBOX_CONSUMER_KEY,
            $this->testUtils->getPrivateKey(),
            Environment::SANDBOX
        );
    }

    public function testService()
    {
        $options = new CountrySubdivisionAtmLocationRequestOptions("USA");
        $countrySubdivisions = $this->service->getCountrySubdivisions($options);
        $this->assertTrue(count($countrySubdivisions->getCountrySubdivision()) > 0);
    }

}
 