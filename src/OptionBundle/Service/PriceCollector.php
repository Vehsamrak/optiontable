<?php
/**
 * Author: Vehsamrak
 * Date Created: 06.02.16 17:43
 */

namespace OptionBundle\Service;

use OptionBundle\Exception\WrongMonth;

class PriceCollector
{

    /**
     * @param int $monthNumber
     * @return string
     * @throws WrongMonth
     */
    public function getMonthLetter(int $monthNumber): string
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
