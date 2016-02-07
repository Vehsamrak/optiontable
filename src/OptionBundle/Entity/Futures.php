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
     * @var int
     * @ORM\Column(name="option_point_price", type="integer")
     */
    private $optionPointPrice;

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
     * Features constructor
     * @param int       $optionPointPrice
     * @param \DateTime $expiration
     * @param Symbol    $symbol
     */
    public function __construct(
        int $optionPointPrice,
        \DateTime $expiration,
        Symbol $symbol
    ) {
        $this->optionPointPrice = $optionPointPrice;
        $this->expiration = $expiration;
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
     * Price of option point
     * @return int
     */
    public function getOptionPointPrice(): int
    {
        return $this->optionPointPrice;
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
