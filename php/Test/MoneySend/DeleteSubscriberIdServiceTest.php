<?php

include_once dirname(__FILE__) . '/../../common/Environment.php';
include_once dirname(__FILE__) . '/../TestUtils.php';
include_once dirname(__FILE__) . '/../../services/MoneySend/services/DeleteSubscriberIdService.php';
include_once dirname(__FILE__) . '/../../services/MoneySend/domain/DeleteSubscriberId.php';
include_once dirname(__FILE__) . '/../../services/MoneySend/domain/DeleteSubscriberIdRequest.php';

class CardMappingServiceTest extends \PHPUnit_Framework_TestCase {

    private $cardMappingService;

    public function setUp() {
        $testUtils = new TestUtils(Environment::SANDBOX);
        $this->deleteSubscriberIdService = new DeleteSubscriberIdService(TestUtils::SANDBOX_CONSUMER_KEY, $testUtils->getPrivateKey(), Environment::SANDBOX);
    }

    public function testDeleteSubscriberIdService() {
        $deleteSubscriberIdRequest = new DeleteSubscriberIdRequest();
        $deleteSubscriberIdRequest->setSubscriberId("examplePHP@email.com");
        $deleteSubscriberIdRequest->setSubscriberType("EMAIL_ADDRESS");
        $deleteSubscriberId = $this->deleteSubscriberIdService->getDeleteSubscriberId($deleteSubscriberIdRequest);
        $this->assertTrue($deleteSubscriberId->getRequestId() != null && $deleteSubscriberId->getRequestId() > 0);
    }

}