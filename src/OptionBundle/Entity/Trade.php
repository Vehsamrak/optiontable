<?php

namespace OptionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Торговая сделка
 * @ORM\Table(name="trades")
 * @ORM\Entity(repositoryClass="OptionBundle\Repository\TradeRepository")
 */
class Trade
{

    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Направление сделки
     * @var int
     * @ORM\Column(name="direction", type="string", length=4, nullable=false)
     */
    private $direction;

    /**
     * @var OptionPrice
     * @ORM\ManyToOne(targetEntity="OptionPrice")
     * @ORM\JoinColumn(name="price_open", nullable=false)
     */
    private $openPrice;

    /**
     * @var OptionPrice
     * @ORM\ManyToOne(targetEntity="OptionPrice")
     * @ORM\JoinColumn(name="price_close", nullable=true)
     */
    private $closePrice;

    /**
     * @var OptionPrice
     * @ORM\ManyToOne(targetEntity="OptionPrice")
     * @ORM\JoinColumn(name="price_high", nullable=false)
     */
    private $highPrice;

    /**
     * @var OptionPrice
     * @ORM\ManyToOne(targetEntity="OptionPrice")
     * @ORM\JoinColumn(name="price_low", nullable=false)
     */
    private $lowPrice;

    /**
     * Объем сделки. Количество контрактов
     * @var int
     * @ORM\Column(name="volume", type="integer", nullable=false)
     */
    private $volume;

    /**
     * @param OptionPrice $openPrice
     */
    public function __construct(string $direction, OptionPrice $openPrice, int $volume)
    {
        $this->direction = $direction;
        $this->openPrice = $openPrice;
        $this->highPrice = $openPrice;
        $this->lowPrice = $openPrice;
        $this->volume = $volume;
    }

    /**
     * Get id
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * Get openPrice
     * @return string
     */
    public function getOpenPrice()
    {
        return $this->openPrice;
    }

    /**
     * Get closePrice
     * @return string
     */
    public function getClosePrice()
    {
        return $this->closePrice;
    }

    /**
     * Set closePrice
     * @param string $closePrice
     * @return Trade
     */
    public function setClosePrice($closePrice)
    {
        $this->closePrice = $closePrice;

        return $this;
    }

    /**
     * Get highPrice
     * @return string
     */
    public function getHighPrice()
    {
        return $this->highPrice;
    }

    /**
     * Set highPrice
     * @param string $highPrice
     * @return Trade
     */
    public function setHighPrice($highPrice)
    {
        $this->highPrice = $highPrice;

        return $this;
    }

    /**
     * Get lowPrice
     * @return string
     */
    public function getLowPrice()
    {
        return $this->lowPrice;
    }

    /**
     * Set lowPrice
     * @param string $lowPrice
     * @return Trade
     */
    public function setLowPrice($lowPrice)
    {
        $this->lowPrice = $lowPrice;

        return $this;
    }

    /**
     * @return int
     */
    public function getVolume()
    {
        return $this->volume;
    }
}
