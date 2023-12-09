<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Village
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name;

    #[ORM\OneToMany(mappedBy: 'village', targetEntity: Building::class)]
    private Collection $buildings;

    #[ORM\ManyToOne(targetEntity: Player::class, inversedBy: 'villages')]
    private Player $player;

    public function __construct(Player $player, ?string $name = null)
    {
        $this->player = $player;
        $this->name = $name;
        if ($name === null) {
            $this->name = $player->getName() . "'s wioska";
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return Collection|Building[]
     */
    public function getBuildings(): Collection
    {
        return $this->buildings;
    }

    public function getPlayer(): Player
    {
        return $this->player;
    }
}
