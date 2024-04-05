<?php
declare(strict_types=1);

namespace App\Commands;

use App\Model\Process\Process;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
class RunScript extends Command
{

    /**
     * @var Process
     */
    private Process $process;

    /**
     * @param string|null $name
     */
    public function __construct(?string $name = null)
    {
        $this->process = new Process();
        parent::__construct($name);
    }

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this->setName('run:script')
            ->setDescription('Run script.')
            ->setHelp('Run script.');
    }

    /**
     * @param  InputInterface  $input
     * @param  OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $amounts = $this->process->process();
        if (!empty($amounts)) {
            foreach ($amounts as $amount) {
                $output->writeln("$amount");
            }
            return Command::SUCCESS;
        } else {
            $output->writeln('Something went wrong. Please check logs!');
            return Command::FAILURE;

        }
    }
}
