<?php

namespace OptionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OptionContract
 * @ORM\Table(name="option")
 * @ORM\Entity(repositoryClass="OptionBundle\Repository\OptionContractRepository")
 */
class OptionContract
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
     * @return Futures
     */
    public function getFutures(): Futures
    {
        return $this->futures;
    }
}
