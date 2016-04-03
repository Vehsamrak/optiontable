<?php

namespace OptionBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use OptionBundle\Exception\WrongOptionType;

/**
 * Опционный контракт
 * @ORM\Table(name="option_contract", uniqueConstraints={
 *     @ORM\UniqueConstraint(name="unique_option_type_futures_strike", columns={"type", "futures_id", "strike"})
 * })
 * @ORM\Entity(repositoryClass="OptionBundle\Repository\OptionContractRepository")
 */
class OptionContract
{
    const TYPE_PUT = 'put';
    const TYPE_CALL = 'call';

    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="type", type="string", length=4)
     */
    private $type;

    /**
     * @var float
     * @ORM\Column(name="strike", type="float")
     */
    private $strike;

    /**
     * @var Futures
     * @ORM\ManyToOne(targetEntity="Futures")
     */
    private $futures;

    /**
     * @var PersistentCollection|OptionPrice[]
     * @ORM\OneToMany(targetEntity="OptionPrice", mappedBy="optionContract")
     */
    private $optionPrices;

    /**
     * @param string  $type
     * @param Futures $futures
     * @param float   $strike
     * @throws WrongOptionType
     */
    public function __construct(
        string $type,
        Futures $futures,
        float $strike
    )
    {
        if ($type !== self::TYPE_CALL && $type !== self::TYPE_PUT) {
            throw new WrongOptionType();
        }

        $this->type = $type;
        $this->strike = $strike;
        $this->futures = $futures;
        $this->optionPrices = new ArrayCollection();
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
     * Get type
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Get strike
     * @return float
     */
    public function getStrike(): float
    {
        return $this->strike;
    }

    /**
     * Get futures
     * @return Futures
     */
    public function getFutures(): Futures
    {
        return $this->futures;
    }

    /**
     * @return OptionPrice[]
     */
    public function getOptionPrices(): PersistentCollection
    {
        return $this->optionPrices;
    }
}
