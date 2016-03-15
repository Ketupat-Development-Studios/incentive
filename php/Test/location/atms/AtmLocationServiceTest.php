<?php
require_once('../../../common/Environment.php');
require_once('../../../services/location/atms/AtmLocationService.php');
require_once('../../TestUtils.php');
require_once('../../../services/location/domain/options/atms/AtmLocationRequestOptions.php');


class AtmLocationServiceTest extends \PHPUnit_Framework_TestCase {

    private $testUtils;
    private $service;

    public function setUp()
    {
        $this->testUtils = new TestUtils(Environment::PRODUCTION);
        $this->service = new AtmLocationService(
            TestUtils::LOCATION_PRODUCTION_CONSUMER_KEY,
            $this->testUtils->getPrivateKey(),
            Environment::PRODUCTION
        );
    }

    public function testGetByNumericPostalCode()
    {
        $options = new AtmLocationRequestOptions(0,25);
        $options->setPostalCode("46320");
        $options->setCountry("USA");
        $atms = $this->service->getAtms($options);
        $this->assertTrue(count($atms->getAtm()) > 0);
    }

    public function testGetByForeignPostalCode()
    {
        $options = new AtmLocationRequestOptions(0,25);
        $options->setPostalCode("068897");
        $options->setCountry("SGP");
        $atms = $this->service->getAtms($options);
        $this->assertTrue(count($atms->getAtm()) > 0);
    }

    public function testGetByAlphaNumericPostalCode()
    {
        $options = new AtmLocationRequestOptions(0,25);
        $options->setPostalCode("60606-6301");
        $options->setCountry("USA");
        $atms = $this->service->getAtms($options);
        $this->assertTrue(count($atms->getAtm()) > 0);
    }

    public function testByLatLong()
    {
        $options = new AtmLocationRequestOptions(0,25);
        $options->setLatitude(1.2833);
        $options->setLongitude(103.8499);
        $options->setRadius(5);
        $options->setDistanceUnit(AtmLocationRequestOptions::KILOMETER);
        $atms = $this->service->getAtms($options);
        $this->assertTrue(count($atms->getAtm()) > 0);
    }

    public function testByAddress()
    {
        $options = new AtmLocationRequestOptions(0,25);
        $options->setAddressLine1("BLK 1 ROCHOR ROAD UNIT 01-640 ROCHOR ROAD");
        $options->setCountry("SGP");
        $atms = $this->service->getAtms($options);
        $this->assertTrue(count($atms->getAtm()) > 0);
    }

    public function testByCity()
    {
        $options = new AtmLocationRequestOptions(0,25);
        $options->setCity("CHICAGO");
        $options->setCountry("USA");
        $atms = $this->service->getAtms($options);
        $this->assertTrue(count($atms->getAtm()) > 0);
    }

    public function testByCountrySubdivision()
    {
        $options = new AtmLocationRequestOptions(0,25);
        $options->setCountrySubdivision("IL");
        $options->setCountry("USA");
        $atms = $this->service->getAtms($options);
        $this->assertTrue(count($atms->getAtm()) > 0);
    }

    public function testBySupportEMV()
    {
        $options = new AtmLocationRequestOptions(0,25);
        $options->setSupportEmv(AtmLocationRequestOptions::SUPPORT_EMV_YES);
        $options->setLatitude(1.2833);
        $options->setLongitude(103.8499);
        $atms = $this->service->getAtms($options);
        $this->assertTrue(count($atms->getAtm()) > 0);
    }
}
 