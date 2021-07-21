<?php


namespace App\Tests\Behat\User;


use App\Tests\Behat\RequestContext;
use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Webmozart\Assert\Assert;

class CheckUserResponses implements Context
{
    private $requestContext;

    private const userType = 'User';
    private const collection = 'hydra:Collection';
    private const edited = 'EditedUser';

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
     * @Then I should check the Register Response
     */
    public function iShouldCheckTheResponseOfTheRegister(): void
    {
        $this->requestContext->printDebug();

        $response = $this->requestContext->getLastResponse();
        $responseData = $this->requestContext->getLastResponseData($response);

        Assert::isArray($responseData);
        $this->assertUser($responseData);
    }

    /**
     * @Then I should check the GET All Users Response
     */
    public function iShouldCheckTheResponseOfTheGETAllUsers(): void
    {
        $this->requestContext->printDebug();

        $response = $this->requestContext->getLastResponse();
        $responseData = $this->requestContext->getLastResponseData($response);

        Assert::isArray($responseData);
        Assert::same($responseData['@type'], self::collection);
        $users = $responseData['hydra:member'];
        Assert::isArray($users);
        $this->assertUser($users[0]);

    }

    /**
     * @Then I should check the GET User By Id Response
     */
    public function iShouldCheckTheResponseOfTheGETUserById(): void
    {
        $this->requestContext->printDebug();

        $response = $this->requestContext->getLastResponse();
        $responseData = $this->requestContext->getLastResponseData($response);

        $this->assertUser($responseData);

    }

    /**
     * @Then I should check the Login Response
     */
    public function iShouldCheckTheResponseOfTheLogin(): void
    {
        $this->requestContext->printDebug();

        $response = $this->requestContext->getLastResponse();
        $responseData = $this->requestContext->getLastResponseData($response);

        Assert::isArray($responseData);
        Assert::string($responseData['token']);
    }

    /**
     * @Then I should check the PUT User Response
     */
    public function iShouldCheckTheResponseOfThePUTUser(): void
    {
        $this->requestContext->printDebug();

        $response = $this->requestContext->getLastResponse();
        $responseData = $this->requestContext->getLastResponseData($response);

        $this->assertUser($responseData);
        Assert::same($responseData['name'], self::edited);
    }

    private function assertUser(array $user): Void
    {
        Assert::same($user['@type'], self::userType);
        Assert::string($user['name']);
        Assert::email($user['email']);
        Assert::isArray($user['roles']);
        Assert::keyExists($user, 'createdAt');
        Assert::keyExists($user, 'updatedAt');
    }
}