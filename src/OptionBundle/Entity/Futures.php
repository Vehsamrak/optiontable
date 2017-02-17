<?php

namespace OptionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Фьючерсный контракт
 * @ORM\Table(name="futures", uniqueConstraints={
 *     @ORM\UniqueConstraint(name="unique_futures_expiration_symbol", columns={"expiration", "symbol"})
 * })
 * @ORM\Entity(repositoryClass="OptionBundle\Repository\FuturesRepository")
 */
class Futures
{

    const EXPIRATION_DATE_FORMAT = 'Y-m-d';
    const EXPIRATION_YEAR_FORMAT = 'y';
    const EXPIRATION_MONTH_FORMAT = 'n';
    const DEFAULT_MARGIN = 3200;

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
     * @var int
     * @ORM\Column(name="margin", type="integer")
     */
    private $margin;

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
        $this->margin = self::DEFAULT_MARGIN;
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
     * @return string
     */
    public function getExpiration(): string
    {
        return $this->expiration->format(self::EXPIRATION_DATE_FORMAT);
    }

    /**
     * Year of expiration
     * @return int
     */
    public function getExpirationYear(): int
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

    /**
     * Month of option contract, next month after expiration date
     * @return int
     */
    public function getExpirationMonth(): int
    {
        return (int) $this->expiration->format(self::EXPIRATION_MONTH_FORMAT) + 1;
    }

    /**
     * @return int
     */
    public function getDaysToExpiration(): int
    {
        $now = new \DateTime();

        if ($now > $this->expiration) {
            return 0;
        } else {
            return $now->diff($this->expiration)->days;
        }
    }

    public function isExpired(): bool
    {
        return (new \DateTime())->diff($this->expiration)->invert;
    }
}
