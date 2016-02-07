<?php
/**
 * Author: Vehsamrak
 * Date Created: 06.02.16 17:43
 */

namespace OptionBundle\Service;

use OptionBundle\Entity\Symbol;
use OptionBundle\Exception\WrongMonth;

class PriceCollector
{

    /**
     * @var \DateTime
     */
    private $dateTime;

    /**
     * @param \DateTime $dateTime
     */
    public function __construct(\DateTime $dateTime)
    {

        $this->dateTime = $dateTime;
    }

    /**
     * @param Symbol $symbol
     * @param int    $monthNumber
     * @throws WrongMonth
     * @return string
     */
    public function collectOptionPrices(Symbol $symbol, int $monthNumber): string
    {
        $optionTableUrl = $this->createOptionTableUrl($symbol, $monthNumber);
    }

    /**
     * @param Symbol $symbol
     * @param int    $monthNumber
     * @return string
     * @throws WrongMonth
     */
    private function createOptionTableUrl(Symbol $symbol, int $monthNumber): string
    {
        if ($monthNumber > 12) {
            throw new WrongMonth();
        }

        $currentMonth = (int) $this->dateTime->format('n');
        $currentYear = (int) $this->dateTime->format('Y');
        $yearOfContract = ($currentMonth > $monthNumber) ? $currentYear + 1 : $currentYear;

        $optionTableUrl = sprintf(
            'http://www.barchart.com/commodityfutures/null/options/%s%s%d?view=split&mode=i',
            $symbol->getSymbol(),
            $this->getMonthLetter($monthNumber),
            $yearOfContract
        );

        return $optionTableUrl;
    }

    /**
     * @param int $monthNumber
     * @return string
     * @throws WrongMonth
     */
    private function getMonthLetter(int $monthNumber): string
    {
        $monthLetters = [
            1  => 'F',
            2  => 'G',
            3  => 'H',
            4  => 'J',
            5  => 'K',
            6  => 'M',
            7  => 'N',
            8  => 'Q',
            9  => 'U',
            10 => 'V',
            11 => 'X',
            12 => 'Z',
        ];

        if (!array_key_exists($monthNumber, $monthLetters)) {
            throw new WrongMonth();
        }

        return $monthLetters[$monthNumber];
    }
}
