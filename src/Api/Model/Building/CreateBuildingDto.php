<?php

namespace App\Api\Model\Building;

use App\Entity\Enum\BuildingType;
use Symfony\Component\Validator\Constraints as Assert;

class CreateBuildingDto
{
    public function __construct(
        #[Assert\NotBlank]
        public int $villageId,
        #[Assert\NotBlank]
        #[Assert\Choice(choices: BuildingType::ALL)]
        public string $buildingType,
    ) {
    }
}