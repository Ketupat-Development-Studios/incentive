<?php

include_once dirname(__FILE__) . '/../../common/Environment.php';
include_once dirname(__FILE__) . '/../TestUtils.php';
include_once dirname(__FILE__) . '/../../services/MoneySend/services/CardMappingService.php';
include_once dirname(__FILE__) . '/../../services/MoneySend/domain/CreateMapping.php';
include_once dirname(__FILE__) . '/../../services/MoneySend/domain/CreateMappingRequest.php';
include_once dirname(__FILE__) . '/../../services/MoneySend/domain/Address.php';
include_once dirname(__FILE__) . '/../../services/MoneySend/domain/CardholderFullName.php';
include_once dirname(__FILE__) . '/../../services/MoneySend/domain/InquireMapping.php';
include_once dirname(__FILE__) . '/../../services/MoneySend/domain/InquireMappingRequest.php';
include_once dirname(__FILE__) . '/../../services/MoneySend/domain/UpdateMappingRequest.php';
include_once dirname(__FILE__) . '/../../services/MoneySend/domain/options/UpdateMappingRequestOptions.php';
include_once dirname(__FILE__) . '/../../services/MoneySend/domain/UpdateMapping.php';
include_once dirname(__FILE__) . '/../../services/MoneySend/domain/options/DeleteMappingRequestOptions.php';

class CardMappingServiceTest extends \PHPUnit_Framework_TestCase {

    private $cardMappingService;

    public function setUp() {
        $testUtils = new TestUtils(Environment::SANDBOX);
        $this->cardMappingService = new CardMappingService(TestUtils::SANDBOX_CONSUMER_KEY, $testUtils->getPrivateKey(), Environment::SANDBOX);
    }

    public function testCreateMappingServiceTest() {
        $createRequest = new \CreateMappingRequest();
        $address = new \Address();
        $createRequest->setICA("009674");
        $createRequest->setSubscriberId("examplePHPSending@email.com");
        $createRequest->setSubscriberType("EMAIL_ADDRESS");
        $createRequest->setAccountUsage("SENDING");
        $createRequest->setAccountNumber("5184680430000006");
        $createRequest->setDefaultIndicator("T");
        $createRequest->setExpiryDate(201409);
        $createRequest->setAlias("My Debit Card");
        $createRequest->setAddress($address);
        $createRequest->getAddress()->setLine1("123 Main Street");
        $createRequest->getAddress()->setLine2("#5A");
        $createRequest->getAddress()->setCity("OFallon");
        $createRequest->getAddress()->setCountrySubdivision("MO");
        $createRequest->getAddress()->setCountry("USA");
        $createRequest->getAddress()->setPostalCode(63368);
        $createRequest->setCardholderFullName(new CardholderFullName());
        $createRequest->getCardholderFullName()->setCardholderFirstName("John");
        $createRequest->getCardholderFullName()->setCardholderMiddleName("Q");
        $createRequest->getCardholderFullName()->setCardholderLastName("Public");
        $createRequest->setDateOfBirth(19460102);
        $createMapping = $this->cardMappingService->getCreateMapping($createRequest);
        $this->assertTrue($createMapping->getRequestId() != null && $createMapping->getRequestId() > 0);
        $this->assertTrue($createMapping->getMapping()->getMappingId() > 0);
    }

    public function testInquireMappingServiceTest() {
        $inquireRequest = new InquireMappingRequest();
        $inquireRequest->setSubscriberId("examplePHP@email.com");
        $inquireRequest->setSubscriberType("EMAIL_ADDRESS");
        $inquireRequest->setAccountUsage("RECEIVING");
        $inquireRequest->setAlias("My Debit Card");
        $inquireRequest->setDataResponseFlag(3);
        $inquireMapping = $this->cardMappingService->getInquireMapping($inquireRequest);
        $this->assertTrue($inquireMapping->getRequestId() != null && $inquireMapping->getRequestId() > 0);
        $this->assertTrue($inquireMapping->getMappings()->getMapping(0)->getMappingId() > 0);
    }

    public function testUpdateMappingServiceTest() {
        $inquireRequest = new InquireMappingRequest();
        $inquireRequest->setSubscriberId("examplePHP@email.com");
        $inquireRequest->setSubscriberType("EMAIL_ADDRESS");
        $inquireMapping = $this->cardMappingService->getInquireMapping($inquireRequest);
        $updateRequest = new \UpdateMappingRequest();
        $updateRequestOptions = new UpdateMappingRequestOptions();
        $updateRequestOptions->setMappingId($inquireMapping->getMappings()->getMapping(0)->getMappingId());
        $address = new \Address();
        $updateRequest->setAccountUsage("RECEIVING");
        $updateRequest->setAccountNumber("5184680430000006");
        $updateRequest->setDefaultIndicator("T");
        $updateRequest->setExpiryDate(201409);
        $updateRequest->setAlias("Debit Card");
        $updateRequest->setAddress($address);
        $updateRequest->getAddress()->setLine1("123 Main Street");
        $updateRequest->getAddress()->setLine2("#5A");
        $updateRequest->getAddress()->setCity("OFallon");
        $updateRequest->getAddress()->setCountrySubdivision("MO");
        $updateRequest->getAddress()->setCountry("USA");
        $updateRequest->getAddress()->setPostalCode(63368);
        $updateRequest->setCardholderFullName(new CardholderFullName());
        $updateRequest->getCardholderFullName()->setCardholderFirstName("John");
        $updateRequest->getCardholderFullName()->setCardholderMiddleName("Q");
        $updateRequest->getCardholderFullName()->setCardholderLastName("Public");
        $updateRequest->setDateOfBirth(19460102);
        $updateMapping = $this->cardMappingService->getUpdateMapping($updateRequest, $updateRequestOptions);
        $this->assertTrue($updateMapping->getRequestId() != null && $updateMapping->getRequestId() > 0);
        $this->assertTrue($updateMapping->getMapping()->getMappingId() > 0);
    }

    public function testDeleteMappingServiceTest() {
        $inquireRequest = new InquireMappingRequest();
        $inquireRequest->setSubscriberId("examplePHP@email.com");
        $inquireRequest->setSubscriberType("EMAIL_ADDRESS");
        $inquireMapping = $this->cardMappingService->getInquireMapping($inquireRequest);
        $mapping = $inquireMapping->getMappings()->getMapping();
        $deleteOptions = new DeleteMappingRequestOptions();
        $deleteOptions->setMappingId($mapping[0]->getMappingId());
        $deleteMapping = $this->cardMappingService->getDeleteMapping($deleteOptions);
        $this->assertTrue($deleteMapping->getRequestId() != null && $deleteMapping->getRequestId() > 0);
        $this->assertTrue($deleteMapping->getMapping()->getMappingId() > 0);
    }

}
 