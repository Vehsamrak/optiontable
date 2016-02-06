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
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="symbol", type="string", length=2, unique=true)
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
     * Get id
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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
