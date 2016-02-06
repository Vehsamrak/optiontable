<?php

namespace OptionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use OptionBundle\Exception\WrongOptionType;

/**
 * OptionContract
 * @ORM\Table(name="option", uniqueConstraints={
 *     @ORM\UniqueConstraint(name="unique_option_type_strike", columns={"type", "strike"})
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
     * @param string $type
     * @param float  $strike
     * @throws WrongOptionType
     */
    public function __construct(string $type, float $strike)
    {
        if ($type !== self::TYPE_CALL && $type !== self::TYPE_PUT) {
            throw new WrongOptionType();
        }

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
