<?php

namespace App\Entity;

use App\Entity\Enum\ResourceType;
use Doctrine\Common\Collections\ArrayCollection;
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

    #[ORM\OneToMany(mappedBy: 'village', targetEntity: Resource::class, cascade: ['persist'])]
    private Collection $resources;

    public function __construct(Player $player, ?string $name = null)
    {
        $this->buildings = new ArrayCollection();
        $this->resources = new ArrayCollection();

        $this->player = $player;
        $this->name = $name;
        if ($name === null) {
            $this->name = $player->getName() . "'s wioska";
        }

        foreach (ResourceType::cases() as $case) {
            $this->resources->add(
                new Resource($case, $this)
            );
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

    /**
     * @return Collection|Resource[]
     */
    public function getResources(): Collection
    {
        return $this->resources;
    }
}
