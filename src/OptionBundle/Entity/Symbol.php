<?php

namespace OptionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Symbol
 * @ORM\Table(name="symbol")
 * @ORM\Entity(repositoryClass="OptionBundle\Repository\SymbolRepository")
 */
class Symbol
{

    /**
     * @var string
     * @ORM\Column(name="symbol", type="integer")
     * @ORM\Id
     */
    private $symbol;

    /**
     * @param string $symbol
     */
    public function __construct(string $symbol)
    {
        $this->symbol = $symbol;
    }

    /**
     * Get symbol
     * @return string
     */
    public function getSymbol(): string
    {
        return $this->symbol;
    }
}
