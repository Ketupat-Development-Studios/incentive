<?php
require_once('../../../common/Environment.php');
require_once('../../../services/location/merchants/MerchantCategoriesService.php');
require_once('../../TestUtils.php');

class MerchantCategoriesServiceTest extends \PHPUnit_Framework_TestCase {
    private $testUtils;
    private $service;

    public function setUp()
    {
        $this->testUtils = new TestUtils(Environment::SANDBOX);
        $this->service = new MerchantCategoriesService(
            TestUtils::SANDBOX_CONSUMER_KEY,
            $this->testUtils->getPrivateKey(),
            Environment::SANDBOX
        );
    }

    public function testService()
    {
        $categories = $this->service->getCategories();
        $this->assertTrue(count($categories->getCategory()) > 0);
    }
}
 