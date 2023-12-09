<?php

namespace App\Api\Factory;

use App\Api\Model\Village\Building;
use App\Api\Model\Village\GetMethod;
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
        foreach ($village->getBuildings() as $building) {
            $buildings[] = new Building(
                $building->getId(),
                $building->getType()->value,
                $building->getType()->value,
                $building->getLevel(),
            );
        }

        return new GetMethod($buildings);
    }
}