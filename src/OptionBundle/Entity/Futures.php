<?php

namespace OptionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Futures contract
 * @ORM\Table(name="futures", uniqueConstraints={
 *     @ORM\UniqueConstraint(name="unique_futures_expiration_symbol", columns={"expiration", "symbol"})
 * })
 * @ORM\Entity(repositoryClass="OptionBundle\Repository\FuturesRepository")
 */
class Futures
{

    const EXPIRATION_DATE_FORMAT = 'Y-m-d';
    const EXPIRATION_YEAR_FORMAT = 'Y';

    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     * @ORM\Column(name="expiration", type="datetime")
     */
    private $expiration;

    /**
     * @var Symbol
     * @ORM\ManyToOne(targetEntity="Symbol")
     * @ORM\JoinColumn(name="symbol", referencedColumnName="symbol")
     */
    private $symbol;

    /**
     * @param string $expiration
     * @param Symbol $symbol
     */
    public function __construct(
        Symbol $symbol,
        string $expiration
    ) {
        $this->symbol = $symbol;
        $this->expiration = new \DateTime($expiration);
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
     * Expiration date
     */
    public function getExpiration(): string
    {
        return $this->expiration->format(self::EXPIRATION_DATE_FORMAT);
    }

    /**
     * Year of expiration
     */
    public function getExpirationYear(): string
    {
        return $this->expiration->format(self::EXPIRATION_YEAR_FORMAT);
    }

    /**
     * Futures symbol
     * @return Symbol
     */
    public function getSymbol(): Symbol
    {
        return $this->symbol;
    }
}
