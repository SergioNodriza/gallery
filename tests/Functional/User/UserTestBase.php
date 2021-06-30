<?php


namespace App\Tests\Functional\User;


use App\Tests\Functional\TestBase;

class UserTestBase extends TestBase
{
    protected string $endpoint;

    protected function setUp(): void
    {
        parent::setUp();
        $this->endpoint = '/api/users';
    }
}