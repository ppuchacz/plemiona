<?php

namespace App\Entity;

use App\Entity\Enum\ResourceType;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Resource
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ResourceType $type;

    #[ORM\Column]
    private float $amount = 0.0;

    #[ORM\Column('datetime')]
    private \DateTime $updatedAt;

    #[ORM\ManyToOne(targetEntity: Village::class, inversedBy: 'resources')]
    private Village $village;

    public function __construct(ResourceType $type, Village $village)
    {
        $this->type = $type;
        $this->village = $village;
        $this->updatedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ResourceType
    {
        return $this->type;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    public function getVillage(): Village
    {
        return $this->village;
    }

    public function addAmount(float $amount): void
    {
        $this->amount += $amount;
    }

    public function subtractAmount(float $amount): void
    {
        $this->amount -= $amount;
    }
}