<?php

namespace OptionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use OptionBundle\Enum\SymbolEnum;

/**
 * Symbol
 * @ORM\Table(name="symbol")
 * @ORM\Entity(repositoryClass="OptionBundle\Repository\SymbolRepository")
 */
class Symbol
{

    /**
     * @var SymbolEnum
     * @ORM\Column(name="symbol", type="string", length=2)
     * @ORM\Id
     */
    private $symbol;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=64)
     */
    private $name;

    /**
     * @param SymbolEnum $symbol
     * @param string     $name
     */
    public function __construct(SymbolEnum $symbol, string $name)
    {
        $this->symbol = $symbol;
        $this->name = $name;
    }

    /**
     * Get symbol
     * @return SymbolEnum
     */
    public function getSymbol(): SymbolEnum
    {
        return $this->symbol;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
