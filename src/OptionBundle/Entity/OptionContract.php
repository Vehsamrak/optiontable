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
     * OptionContract constructor.
     * @param string $type
     * @param float  $strike
     */
    public function __construct(string $type, float $strike)
    {
        $this->type = $type;
        $this->strike = $strike;
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
}
