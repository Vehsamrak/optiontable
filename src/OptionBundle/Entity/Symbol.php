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
     * @param string $symbol
     */
    public function __construct(string $symbol, string $name)
    {
        $this->symbol = $symbol;
        $this->name = $name;
    }

    /**
     * Get symbol
     * @return string
     */
    public function getSymbol(): string
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
