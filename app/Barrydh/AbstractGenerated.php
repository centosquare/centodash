<?php

namespace App\Barrydh;

use Symfony\Component\Process\Process;
use Knp\Snappy\AbstractGenerator;

class AbstractGenerated extends AbstractGenerator
{
    public function __construct()
    {
        $this->configure();

        $this->setBinary(null);
        $this->setOptions([]);
        $this->env = empty($env) ? null : $env;

        if (\is_callable([$this, 'removeTemporaryFiles'])) {
            \register_shutdown_function([$this, 'removeTemporaryFiles']);
        }
    }
    
    /**
     * This method must configure the media options.
     *
     * @return void
     *
     * @see AbstractGenerator::addOption()
     */
    protected function configure()
    {
    }

    /**
     * Executes the given command via shell and returns the complete output as
     * a string.
     *
     * @param string $command
     *
     * @return array [status, stdout, stderr]
     */
    protected function executeCommand($command)
    {
        if (\method_exists(Process::class, 'fromShellCommandline')) {
            $process = Process::fromShellCommandline($command, null, $this->env);
        } else {
            $process = new Process($command, null, $this->env);
        }

        if (null !== $this->timeout) {
            $process->setTimeout($this->timeout);
        }

        $process->run();

        return [
            $process->getExitCode() != 1 ?: 0,
            $process->getOutput(),
            $process->getErrorOutput(),
        ];
    }

}
