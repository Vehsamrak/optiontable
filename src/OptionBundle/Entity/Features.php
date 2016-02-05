<?php

namespace OptionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Features
 * @ORM\Table(name="features")
 * @ORM\Entity(repositoryClass="OptionBundle\Repository\FeaturesRepository")
 */
class Features
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
     * @var string
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var int
     * @ORM\Column(name="optionPointPrice", type="integer")
     */
    private $optionPointPrice;

    /**
     * @var \DateTime
     * @ORM\Column(name="expiration", type="datetime")
     */
    private $expiration;

    /**
     * @var string
     * @ORM\Column(name="symbol", type="string", length=255)
     */
    private $symbol;

    /**
     * Features constructor
     * @param string    $name
     * @param int       $optionPointPrice
     * @param \DateTime $expiration
     * @param string    $symbol
     */
    public function __construct(string $name, int $optionPointPrice, \DateTime $expiration, string $symbol)
    {
        $this->name = $name;
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
     * Get name
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get optionPointPrice
     * @return int
     */
    public function getOptionPointPrice(): int
    {
        return $this->optionPointPrice;
    }

    /**
     * Get expiration
     */
    public function getExpiration(): string
    {
        return $this->expiration->format(self::EXPIRATION_DATE_FORMAT);
    }

    /**
     * Get expiration year
     */
    public function getExpirationYear(): string
    {
        return $this->expiration->format(self::EXPIRATION_YEAR_FORMAT);
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
