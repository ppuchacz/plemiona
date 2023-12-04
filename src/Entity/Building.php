<?php

namespace App\Entity;
use App\Entity\Enum\BuildingType;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Building
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private BuildingType $type;

    #[ORM\Column]
    private int $level;

    #[ORM\ManyToOne(targetEntity: Village::class, inversedBy: 'buildings')]
    private Village $village;

    public function __construct(BuildingType $type, Village $village, int $level = 1)
    {
        $this->type = $type;
        $this->level = $level;
        $this->village = $village;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): BuildingType
    {
        return $this->type;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function getVillage(): Village
    {
        return $this->village;
    }

    public function addLevel(int $level): void
    {
        $this->level += $level;
    }

    public function subtractLevel(int $level): void
    {
        $this->level -= $level;
    }
}
