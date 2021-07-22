<?php


namespace App\Tests\Behat\Group;


use App\Tests\Behat\RequestContext;
use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Webmozart\Assert\Assert;

class CheckGroupResponses implements Context
{
    private $requestContext;

    private const groupType = 'Group';
    private const editedName = 'EditedName';

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
     * @Then I should check the GET Group By Id Response
     */
    public function iShouldCheckTheResponseOfTheGETGroupById(): void
    {
        $response = $this->requestContext->getLastResponse();
        $responseData = $this->requestContext->getLastResponseData($response);
        $this->assertGroup($responseData);

    }

    /**
     * @Then I should check the PUT Group Response
     */
    public function iShouldCheckTheResponseOfThePUTGroup(): void
    {
        $response = $this->requestContext->getLastResponse();
        $responseData = $this->requestContext->getLastResponseData($response);

        $this->assertGroup($responseData);
        Assert::same($responseData['name'], self::editedName);
    }

    /**
     * @Then I should check the Create Group Response
     */
    public function iShouldCheckTheResponseOfTheCreateGroup(): void
    {
        $response = $this->requestContext->getLastResponse();
        $responseData = $this->requestContext->getLastResponseData($response);

        $this->assertGroup($responseData);
    }

    /**
     * @Then I should check the Interact Group Response
     */
    public function iShouldCheckTheResponseOfTheInteractGroup(): void
    {
        $response = $this->requestContext->getLastResponse();
        $responseData = $this->requestContext->getLastResponseData($response);

        Assert::string($responseData['result']);
    }

    private function assertGroup($group): void
    {
        Assert::same($group['@type'], self::groupType);
        Assert::string($group['name']);
        Assert::string($group['owner']);
        Assert::integer($group['numPhotos']);
        Assert::isArray($group['photos']);
        Assert::string($group['createdAt']);
        Assert::string($group['updatedAt']);
    }
}