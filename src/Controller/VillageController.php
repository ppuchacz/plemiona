<?php

namespace App\Controller;

use App\Entity\Building;
use App\Entity\Enum\BuildingType;
use App\Entity\Village;
use App\Service\PlayerSession;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VillageController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/{village}', 'app_village_index')]
    public function villageView(
        #[MapEntity(mapping: ['village' => 'id'])]
        Village $village,
    ): Response
    {
        /** @var Building[] $buildings */
        $buildings = $village->getBuildings();
        $existentTypes = [];
        foreach ($buildings as $building) {
            $existentTypes[] = $building->getType();
        }

        $nonExistent = [];
        foreach (BuildingType::cases() as $case) {
            if (in_array($case, $existentTypes)) {
                continue;
            }

            $nonExistent[] = new Building($case, $village);
        }

        return $this->render('village/index.html.twig', [
            'buildings' => $buildings,
            'nonExistent' => $nonExistent
        ]);
    }

    #[Route('/{village}/{type}/up', 'app_village_building_up', methods: Request::METHOD_POST)]
    public function up(
        #[MapEntity(mapping: ['village' => 'id'])]
        Village $village,
        string $type
    ): Response
    {
        $building = $village->getBuildings()->findFirst(function ($key, $element) use ($type){
            return $element->getType()->value === $type;
        });

        if ($building === null) {
            throw new \InvalidArgumentException('Building of type ' . $type . ' does not exists');
        }

        $building->addLevel(1);

        $this->entityManager->persist($building);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_village_index', ['village' => $village->getId()]);
    }

    #[Route('/{village}/{buildingType}', 'app_village_building_create', methods: Request::METHOD_POST)]
    public function create(
        #[MapEntity(mapping: ['village' => 'id'])]
        Village $village,
        string $buildingType
    ): Response
    {
        try {
            $typeEnum = BuildingType::from($buildingType);
        } catch (\ValueError $e) {
            throw new \InvalidArgumentException('Building of type ' . $buildingType . ' is not recognizable', 0, $e);
        }

        $building = new Building($typeEnum, $village, 1);
        $this->entityManager->persist($building);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_village_index', ['village' => $village->getId()]);
    }
}