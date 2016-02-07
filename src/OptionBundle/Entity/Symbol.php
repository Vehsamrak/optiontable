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
     * @param string $symbol
     * @param string $name
     * @throws WrongSymbol
     */
    public function __construct(string $symbol)
    {
        if (!SymbolCode::isValid($symbol)) {
            throw new WrongSymbol($symbol);
        }

        $this->symbol = $symbol;
    }

    /**
     * Get symbol
     */
    public function getSymbol(): string
    {
        return $this->symbol;
    }
}
