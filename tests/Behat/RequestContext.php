<?php

namespace App\Tests\Behat;

use App\Repository\UserRepository;
use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Gherkin\Node\PyStringNode;
use Exception;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Webmozart\Assert\Assert;
use function json_decode;

class RequestContext implements Context
{

    private KernelContext $kernelContext;
    private array $serverParameters;

    private UserRepository $repository;
    private KernelBrowser $client;
    private Response $response;

    public function __construct(UserRepository $repository, KernelBrowser $client)
    {
        $this->repository = $repository;
        $this->serverParameters = [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_ACCEPT' => 'application/ld+json'
        ];
        $this->client = $client;
    }

    /**
     * @BeforeScenario
     * @param BeforeScenarioScope $scope
     * @noinspection PhpPossiblePolymorphicInvocationInspection
     */
    public function gatherContexts(BeforeScenarioScope $scope): void
    {
        $environment = $scope->getEnvironment();
        $this->kernelContext = $environment->getContext(KernelContext::class);
    }

    /**
     * @When I do a :method to :endpoint
     * @When I do a :method to :endpoint as :userID
     * @param string $method
     * @param string $endpoint
     * @param PyStringNode|null $payload
     * @param string|null $userID
     * @return Response
     * @throws Exception
     */
    public function doRequest(string $method, string $endpoint, ?string $userID = null, ?PyStringNode $payload = null): Response
    {
        $url = "http://localhost:250/api/$endpoint";

        if ($userID) {
            $this->serverParameters += [
                'HTTP_Authorization' => sprintf('Bearer %s', $this->getUserJWT($userID))
            ];
        }

        $this->client->setServerParameters($this->serverParameters);

        if ($payload) {
            $json = json_decode($payload->getRaw(), true, 512, JSON_THROW_ON_ERROR);
            $this->client->request($method, $url, [], [], [], json_encode($json));
        } else {
            $this->client->request($method, $url);
        }

        $this->printDebug($url);

        $this->response = $this->client->getResponse();
        return $this->response;
    }

    /**
     * @throws Exception
     */
    public function getUserJWT($user_uuid): string
    {
        $user = $this->repository->findOneBy(['id' => $user_uuid]);
        return str_replace("\n", '', $this->kernelContext->runCLICommand('lexik:jwt:generate-token', ['username' => $user->getUsername()]));
    }

    /**
     * @return Response
     */
    public function getLastResponse(): Response
    {
        return $this->response;
    }

    public function getLastResponseData(Response $response): array
    {
        return json_decode($response->getContent(), true);
    }

    /**
     * @Then I should get :code
     * @param int $code
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function checkCode(int $code): void
    {
        $this->printDebug();
        Assert::same($this->getLastResponse()->getStatusCode(), $code);
    }

    /**
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function printDebug(string $url = null): void
    {
        if (!$url) {
            echo current($this->getLastResponse()->headers->all()['x-debug-token-link'] ?? ['Sin X-Debug']);
        }

        echo $url;
    }
}