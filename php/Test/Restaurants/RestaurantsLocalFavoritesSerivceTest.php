<?php
include_once dirname(__FILE__) . '/../../common/Environment.php';
include_once dirname(__FILE__) . '/../../services/restaurants/services/RestaurantsLocalFavoritesService.php';
include_once dirname(__FILE__) . '/../TestUtils.php';
include_once dirname(__FILE__) . '/../../services/restaurants/domain/options/RestaurantsLocalFavoritesRequestOptions.php';

class RestaurantsLocalFavoritesServiceTest extends \PHPUnit_Framework_TestCase {

    private $testUtils;
    private $service;

    public function setUp()
    {
        $this->testUtils = new TestUtils(Environment::SANDBOX);
        $this->service = new RestaurantsLocalFavoritesService(
            TestUtils::SANDBOX_CONSUMER_KEY,
            $this->testUtils->getPrivateKey(),
            Environment::SANDBOX
        );
    }

    public function testByLatitudeLongitude()
    {
        $options = new RestaurantsLocalFavoritesRequestOptions(
            0,
            25
        );
        $options->setLatitude(38.53463);
        $options->setLongitude(-90.286781);
        $restaurants = $this->service->getRestaurants($options);
        $this->assertTrue(count($restaurants->getRestaurant()) > 0);
    }
}