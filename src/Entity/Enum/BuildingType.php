<?php

namespace App\Entity\Enum;

enum BuildingType: string
{
    case StoneMine = 'stone-mine';
    case WoodMine = 'wood-mine';
    case IronMine = 'iron-mine';
    case TownHall = 'town-hall';
    case Barracks = 'barracks';
    case Stable = 'stable';
    case Wall = 'wall';
}