<?php

namespace Magefast\Qprocess\Console\Command;

use Magefast\Qprocess\Service\Add;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Qprocess extends Command
{
    /**
     * @var Add
     */
    private $addService;

    /**
     * @param Add $addService
     * @param string|null $name
     */
    public function __construct(Add $addService, string $name = null)
    {
        $this->addService = $addService;

        parent::__construct($name);

    }

    /**
     * Initialization of the command.
     */
    protected function configure()
    {
        $this->setName('qprocess:test');
        $this->setDescription('For test Queue message, set message');
        parent::configure();
    }

    /**
     * CLI command description.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $value = 'test' . uniqid();
        $this->addService->execute($value);
        $output->writeln('<info>' . 'Added value: ' . $value . '</info>');
    }
}
