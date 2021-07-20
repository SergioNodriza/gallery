<?php


namespace App\Tests\Behat\User;


use App\Tests\Behat\RequestContext;
use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Webmozart\Assert\Assert;

class CheckUserResponses implements Context
{
    private $requestContext;

    private const userType = 'user';

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

//        dd($responseData);
        Assert::isArray($responseArray);

        $data = $responseArray['data'];
        Assert::isArray($data);
        Assert::count($data, 6);

        Assert::same($data['type'], self::userType);
        Assert::uuid(substr($data['id'], 9));
        Assert::isArray($data['attributes']);
    }
}