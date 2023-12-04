<?php

namespace App\Entity;
use App\Entity\Enum\MaterialType;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Materials
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Player::class, inversedBy: 'materials')]
    private Player $player;

    #[ORM\Column]
    private MaterialType $type;

    #[ORM\Column]
    private int $amount;

    public function __construct(Player $player, MaterialType $type, int $amount)
    {
        $this->player = $player;
        $this->type = $type;
        $this->amount = $amount;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlayer(): Player
    {
        return $this->player;
    }

    public function getType(): MaterialType
    {
        return $this->type;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    public function addAmount(int $amount): void
    {
        $this->amount += $amount;
    }

    public function removeAmount(int $amount): void
    {
        $this->amount -= $amount;
    }
}