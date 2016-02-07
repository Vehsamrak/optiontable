<?php
/**
 * Author: Vehsamrak
 * Date Created: 06.02.16 16:58
 */

namespace OptionBundle\Exception;

use OptionBundle\Enum\SymbolCode;

class WrongSymbol extends \Exception
{

    public function __construct($symbol)
    {
        parent::__construct(
            sprintf(
                'Symbol %s is invalid. Valid symbols are: %s',
                $symbol,
                implode(', ', SymbolCode::values())
            )
        );
    }
}
