<?php

namespace App\Api\Factory;

use App\Api\Model\Village\Available;
use App\Api\Model\Village\Building;
use App\Api\Model\Village\GetMethod;
use App\Entity\Enum\BuildingType;
use App\Entity\Village;
use Doctrine\ORM\EntityManagerInterface;

class VillageGetRequestFactory
{
    private $villageRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->villageRepository = $entityManager->getRepository(Village::class);
    }

    public function create(int $villageId): GetMethod
    {
        $village = $this->villageRepository->find($villageId);
        $buildings = [];
        $existentTypes = [];
        foreach ($village->getBuildings() as $building) {
            $buildings[] = new Building(
                $building->getId(),
                $building->getType()->value,
                $building->getType()->value,
                $building->getLevel(),
            );
            $existentTypes[] = $building->getType();
        }

        $available = [];
        foreach (BuildingType::cases() as $case) {
            if (in_array($case, $existentTypes)) {
                continue;
            }

            $available[] = new Available(
                $case->value,
                $case->value,
            );
        }

        return new GetMethod($buildings, $available);
    }
}