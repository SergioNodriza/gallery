<?php


namespace App\Tests\Behat\Photo;


use App\Tests\Behat\RequestContext;
use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Webmozart\Assert\Assert;

class CheckPhotoResponses implements Context
{
    private $requestContext;

    private const photoType = 'Photo';
    private const collection = 'hydra:Collection';
    private const editedDescription = 'EditedDescription';
    private const editedPrivate = true;

    /**
     * @BeforeScenario
     * @param BeforeScenarioScope $scope
     * @noinspection PhpPossiblePolymorphicInvocationInspection
     */
    public function gatherContexts(BeforeScenarioScope $scope): void
    {

        $environment = $scope->getEnvironment();
        $this->requestContext = $environment->getContext(RequestContext::class);
    }

    /**
     * @Then I should check the GET All Photos Response
     */
    public function iShouldCheckTheResponseOfTheGETAllPhotos(): void
    {
        $response = $this->requestContext->getLastResponse();
        $responseData = $this->requestContext->getLastResponseData($response);

        Assert::isArray($responseData);
        Assert::same($responseData['@type'], self::collection);

        $photos = $responseData['hydra:member'];
        Assert::isArray($photos);
        $this->assertPhoto($photos[0]);
    }

    /**
     * @Then I should check the GET Photo By Id Response
     */
    public function iShouldCheckTheResponseOfTheGETPhotoById(): void
    {
        $response = $this->requestContext->getLastResponse();
        $responseData = $this->requestContext->getLastResponseData($response);

        $this->assertPhoto($responseData);

    }

    /**
     * @Then I should check the Interact Photo Response
     */
    public function iShouldCheckTheResponseOfTheInteractPhoto(): void
    {
        $response = $this->requestContext->getLastResponse();
        $responseData = $this->requestContext->getLastResponseData($response);

        Assert::integer($responseData['newLikes']);
    }

    /**
     * @Then I should check the PUT Photo Response
     */
    public function iShouldCheckTheResponseOfThePUTPhoto(): void
    {
        $response = $this->requestContext->getLastResponse();
        $responseData = $this->requestContext->getLastResponseData($response);

        $this->assertPhoto($responseData);
        Assert::same($responseData['description'], self::editedDescription);
        Assert::same($responseData['private'], self::editedPrivate);
    }

    private function assertPhoto($photo): void
    {
        Assert::same($photo['@type'], self::photoType);
        Assert::string($photo['archive']);
        Assert::string($photo['description']);
        Assert::integer($photo['likes']);
        Assert::boolean($photo['private']);
        Assert::string($photo['owner']);
        Assert::isArray($photo['usersLiked']);
        Assert::isArray($photo['groups']);
        Assert::string($photo['createdAt']);
        Assert::string($photo['updatedAt']);
    }
}