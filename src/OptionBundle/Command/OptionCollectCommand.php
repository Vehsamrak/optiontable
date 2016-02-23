<?php

namespace OptionBundle\Command;

use OptionBundle\Enum\SymbolCode;
use OptionBundle\Exception\ConsoleError;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class OptionCollectCommand extends ContainerAwareCommand
{

    const NUMBER_OF_MONTHS_TO_PARSE = 4;

    protected function configure()
    {
        $this->setName('option:collect');
        $this->setDescription('Parce option prices and save them to database');

        $this->addArgument(
            'symbolOffset',
            InputArgument::REQUIRED,
            'Offset of symbol table to parse');

        $this->addArgument(
            'symbolLimit',
            InputArgument::REQUIRED,
            'Limit of symbol table to parse');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $startTime = microtime(true);

        $symbolOffset = $input->getArgument('symbolOffset');
        $symbolLimit = $input->getArgument('symbolLimit');

        $output->writeln(
            sprintf('Fetching option prices for next %d months. Symbols from %d to %d ...',
                self::NUMBER_OF_MONTHS_TO_PARSE,
                $symbolOffset + 1,
                $symbolOffset + $symbolLimit
            )
        );

        $currentMonth = (int) (new \DateTime())->format('n');

        $container = $this->getContainer();
        $symbolRepository = $container->get('optionboard.symbol_repository');
        $priceCollector = $container->get('optionboard.price_collector');

        $applicableSymbols = $this->getApplicableSymbols($symbolOffset, $symbolLimit);

        foreach ($applicableSymbols as $symbolCode) {
            $symbol = $symbolRepository->findOneBySymbol($symbolCode);

            for ($i = 1; $i < self::NUMBER_OF_MONTHS_TO_PARSE; $i++) {
                $monthNumber = $currentMonth + $i;
                $monthLetter = $priceCollector->getMonthLetter($monthNumber);

                $output->writeln(sprintf('Fetching prices of %s%s ...', $symbolCode, $monthLetter));
                $priceCollector->saveOptionPrices($symbol, $monthNumber);
            }
        }

        $output->writeln(sprintf('Option prices were saved. It takes %d seconds.', microtime(true) - $startTime));
    }

    /**
     * @param int $symbolOffset
     * @param int $symbolLimit
     * @return array
     * @throws ConsoleError
     */
    private function getApplicableSymbols(int $symbolOffset, int $symbolLimit)
    {
        $allSymbols = SymbolCode::values();
        $symbolsCount = count($allSymbols);

        if ($symbolOffset > $symbolsCount) {
            throw new ConsoleError(sprintf('Wrong offset. There are only %d symbol codes.', $symbolsCount));
        }

        return array_slice($allSymbols, $symbolOffset, $symbolLimit);
    }
}
