<?php
include_once dirname(__FILE__) . '/../../common/Environment.php';
include_once dirname(__FILE__) . '/../../services/restaurants/services/CategoriesLocalFavoritesService.php';
include_once dirname(__FILE__) . '/../../test/TestUtils.php';

class CategoriesLocalFavoritesServiceTest extends \PHPUnit_Framework_TestCase {
    private $testUtils;
    private $service;

    public function setUp()
    {
        $this->testUtils = new TestUtils(Environment::SANDBOX);
        $this->service = new CategoriesLocalFavoritesService(
            TestUtils::SANDBOX_CONSUMER_KEY,
            $this->testUtils->getPrivateKey(),
            Environment::SANDBOX
        );
    }

    public function testRestaurantCategories()
    {
        $categories = $this->service->getCategories();
        $this->assertTrue(count($categories->getCategory()) > 0);
    }
}
