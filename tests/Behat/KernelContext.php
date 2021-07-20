<?php

namespace App\Tests\Behat;

use Behat\Behat\Context\Context;
use Exception;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\HttpKernel\KernelInterface;

class KernelContext implements Context
{
    /** @var KernelInterface */
    private $kernel;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @param string $command
     * @param array $parameters
     * @param null $output false to disable output
     * @return string|null
     * @throws Exception
     */
    public function runCLICommand(string $command, array $parameters = [], $output = null): ?string
    {
        $application = new Application($this->kernel);
        $application->setAutoExit(false);
        if ($output === null) {
            $output = new BufferedOutput();
        } else if ($output === false) {
            $output = new NullOutput();
        }

        if (!array_key_exists('--env', $parameters)) {
            $parameters['--env'] = $this->kernel->getEnvironment();
        }

        $input = new ArrayInput(['command' => $command] + $parameters);

        $code = $application->run($input, $output);

        if ($code !== 0) {
            throw new RuntimeException(($output instanceof NullOutput) ? null : $output->fetch(), $code);
        }

        return ($output instanceof NullOutput) ? null : $output->fetch();
    }
}