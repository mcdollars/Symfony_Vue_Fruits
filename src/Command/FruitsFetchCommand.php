<?php

namespace App\Command;

use App\Service\FruitService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'fruits:fetch',
    description: 'This command will fetch all fruits from fruitvice API',
)]
class FruitsFetchCommand extends Command
{
    /**
     * @param FruitService $fruitService
     */
    public function __construct(private readonly FruitService $fruitService)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $this->fruitService->fetchAll();
        $io->success('All Done!');
        return Command::SUCCESS;
    }
}
