<?php

namespace OptionBundle\Command;

use OptionBundle\Enum\SymbolCode;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class OptionCollectCommand extends ContainerAwareCommand
{

    const NUMBER_OF_MONTHS_TO_PARSE = 4;

    protected function configure()
    {
        $this->setName('option:collect');
        $this->setDescription('Parce option prices and save them to database');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $startTime = microtime(true);

        $output->writeln(
            sprintf('Fetching option prices for next %d months ...', self::NUMBER_OF_MONTHS_TO_PARSE)
        );

        $currentMonth = (int) (new \DateTime())->format('n');

        $container = $this->getContainer();
        $symbolRepository = $container->get('optionboard.symbol_repository');
        $priceCollector = $container->get('optionboard.price_collector');

        foreach (SymbolCode::values() as $symbolCode) {
            $symbol = $symbolRepository->findOneBySymbol($symbolCode);

            for ($i = 0; $i < self::NUMBER_OF_MONTHS_TO_PARSE; $i++) {
                $monthNumber = $currentMonth + $i;
                $monthLetter = $priceCollector->getMonthLetter($monthNumber);

                $output->writeln(sprintf('Fetching prices of %s%s ...', $symbolCode, $monthLetter));
                $priceCollector->saveOptionPrices($symbol, $monthNumber);
            }
        }

        $output->writeln(sprintf('Option prices were saved. It takes %d seconds.', microtime(true) - $startTime));
    }
}
