<?php

namespace App\Entity\Enum;

enum ResourceType: string
{
    case Stone = 'stone';
    case Iron = 'iron';
    case Wood = 'wood';
}