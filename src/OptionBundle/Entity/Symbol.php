<?php

namespace OptionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use OptionBundle\Enum\SymbolCode;
use OptionBundle\Exception\WrongSymbol;

/**
 * Symbol
 * @ORM\Table(name="symbol")
 * @ORM\Entity(repositoryClass="OptionBundle\Repository\SymbolRepository")
 */
class Symbol
{

    /**
     * @var string
     * @ORM\Column(name="symbol", type="string", length=2)
     * @ORM\Id
     */
    private $symbol;

    /**
     * @var int
     * @ORM\Column(name="option_point_price", type="integer")
     */
    private $optionPointPrice;

    /**
     * @param string $symbol
     * @param int    $optionPointPrice
     * @throws WrongSymbol
     */
    public function __construct(int $optionPointPrice, string $symbol)
    {
        if (!SymbolCode::isValid($symbol)) {
            throw new WrongSymbol($symbol);
        }

        $this->symbol = $symbol;
        $this->optionPointPrice = $optionPointPrice;
    }

    /**
     * Get symbol
     */
    public function getSymbol(): string
    {
        return $this->symbol;
    }

    /**
     * Price of option point
     * @return int
     */
    public function getOptionPointPrice(): int
    {
        return $this->optionPointPrice;
    }
}
