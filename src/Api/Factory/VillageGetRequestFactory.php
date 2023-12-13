<?php

namespace App\Api\Factory;

use App\Api\Model\Village\Available;
use App\Api\Model\Village\Building;
use App\Api\Model\Village\GetMethod;
use App\Entity\Enum\BuildingType;
use App\Entity\Village;
use App\Translator\AppTranslatorInterface;
use Doctrine\ORM\EntityManagerInterface;

class VillageGetRequestFactory
{
    private $villageRepository;
    private AppTranslatorInterface $translator;

    public function __construct(EntityManagerInterface $entityManager, AppTranslatorInterface $translator)
    {
        $this->villageRepository = $entityManager->getRepository(Village::class);
        $this->translator = $translator;
    }

    public function create(int $villageId): GetMethod
    {
        $village = $this->villageRepository->find($villageId);
        $buildings = [];
        $existentTypes = [];
        foreach ($village->getBuildings() as $building) {
            $buildings[] = new Building(
                $building->getId(),
                $this->translator->translateBuildingByType($building->getType()),
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
                $this->translator->translateBuildingByType($case),
                $case->value,
            );
        }

        return new GetMethod($buildings, $available);
    }
}