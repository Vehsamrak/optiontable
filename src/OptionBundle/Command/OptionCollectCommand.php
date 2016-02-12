<?php

namespace OptionBundle\Command;

use OptionBundle\Enum\SymbolCode;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class OptionCollectCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this->setName('option:collect');
        $this->setDescription('Parce option prices and save them to database');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $startTime = microtime(true);

        $output->writeln('Fetching option prices ...');

        $container = $this->getContainer();

        $symbol = $container->get('optionboard.symbol_repository')->findOneBySymbol(SymbolCode::CRUDE_OIL_WTI);
        $priceCollector = $container->get('optionboard.price_collector');

        $currentMonth = (int) (new \DateTime())->format('n');

        $priceCollector->saveOptionPrices($symbol, $currentMonth);
        $priceCollector->saveOptionPrices($symbol, $currentMonth + 1);
        $priceCollector->saveOptionPrices($symbol, $currentMonth + 2);
        $priceCollector->saveOptionPrices($symbol, $currentMonth + 3);

        $output->writeln(sprintf('Option prices were saved. It takes %d seconds.', microtime(true) - $startTime));
    }

}
