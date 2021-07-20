<?php

namespace App\Tests\Behat;

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;

class DataBaseContext implements Context
{
    private KernelContext $kernelContext;

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

    public function dropDBApi(): void
    {
        $this->kernelContext->runCLICommand('doctrine:database:drop', ['-n' => true, '-f' => true, '--if-exists' => true, '--connection' => 'default']);
    }

    public function setupDBApi(): void
    {
        $this->kernelContext->runCLICommand('doctrine:database:create', ['-n' => true, '--if-not-exists' => true]);
        $this->kernelContext->runCLICommand('doctrine:migrations:migrate', ['-n']);
    }

    /**
     * @AfterScenario @TRANSFER,@REMOVE,@REGISTER,@DELETE
     */
    public function fixturesDBApi(): void
    {
        $this->kernelContext->runCLICommand('hautelook:fixtures:load', ['-n' => true]);
    }


    /**
     * @Then Reset
     */
    public function reset(): void
    {
        $this->dropDBApi();
        $this->setupDBApi();
        $this->fixturesDBApi();
    }
}