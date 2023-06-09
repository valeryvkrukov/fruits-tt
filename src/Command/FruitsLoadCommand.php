<?php

namespace App\Command;

use App\Service\FruitsPersistService;
use App\Service\FruityViceClientService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'fruits:load',
    hidden: false,
    description: 'Load data from https://fruityvice.com/ and fill it to database',
)]
class FruitsLoadCommand extends Command
{
    public function __construct(
        private FruityViceClientService $fruityViceClientService,
        private FruitsPersistService $fruitsPersistService
    ) {
        parent::__construct();
    }

    /**
     * {@inheritDoc}
     */
    protected function configure(): void
    {
        $this
            ->addArgument(
                'mode',
                InputArgument::OPTIONAL,
                'Data loading mode (available modes: "all", "family", "genus", "order")',
                'all'
            )
            ->addOption('param', 'p', InputOption::VALUE_REQUIRED, 'Optional param for non-"all" mode requests')
        ;
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $mode = $input->getArgument('mode');
        $param = $input->getOption('param');
        
        if ($mode !== 'all' && is_null($param)) {
            $io->error(sprintf('The "--param" option is required for mode "%s"', $mode));

            return Command::FAILURE;
        }

        $io->note(sprintf('Used loading mode: %s', $mode));

        $data = $this->fruityViceClientService->fetchData($mode, $param);
        
        if (is_string($data)) {
            $io->error($data);

            return Command::FAILURE;
        } else {
            $result = $this->fruitsPersistService->save($data);

            if ($result !== FruitsPersistService::SUCCESS) {
                $io->error($result);

                return Command::FAILURE;
            }
        }

        $io->success('Data loaded successfully.');

        return Command::SUCCESS;
    }
}
