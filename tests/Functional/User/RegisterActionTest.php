<?php


namespace App\Tests\Functional\User;

use Symfony\Component\HttpFoundation\JsonResponse;

class RegisterActionTest extends UserTestBase
{
    public function testRegister(): void
    {
        $payload = [
            "name" => "Test",
            "email" => "test@email.com",
            "password" => "Test@01"
        ];

        self::$peter->request('POST', sprintf('%s/register', $this->endpoint), [], [], [], json_encode($payload));

        $response = self::$peter->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_CREATED, $response->getStatusCode());
        $this->assertEquals($payload['email'], $responseData['email']);
    }

    public function testRegisterWithMissingParameters(): void
    {
        $payload = [
            "name" => "Test2",
            "password" => "Test2@01"
        ];

        self::$peter->request('POST', sprintf('%s/register', $this->endpoint), [], [], [], json_encode($payload));

        $response = self::$peter->getResponse();
        $this->assertEquals(JsonResponse::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testRegisterWithInvalidPassword(): void
    {
        $payload = [
            "name" => "Test",
            "email" => "test@email.com",
            "password" => "T"
        ];

        self::$peter->request('POST', sprintf('%s/register', $this->endpoint), [], [], [], json_encode($payload));

        $response = self::$peter->getResponse();
        $this->assertEquals(JsonResponse::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
}