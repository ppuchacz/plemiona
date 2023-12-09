<?php

namespace App\Api\Model\Building;

use Symfony\Component\Validator\Constraints as Assert;

class LevelUpBuildingDto
{
    public function __construct(
        #[Assert\NotBlank]
        public int $buildingId,
    ) {
    }
}