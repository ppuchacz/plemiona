<?php

namespace App\Controller;

use App\Api\Factory\VillageGetRequestFactory;
use App\Entity\Building;
use App\Entity\Enum\BuildingType;
use App\Entity\Village;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/village', name: 'app_village_')]
class VillageController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/{village}', 'get')]
    public function getMethod(
        #[MapEntity(mapping: ['village' => 'id'])]
        Village $village,
        VillageGetRequestFactory $factory
    ): Response
    {
        $model = $factory->create($village->getId());

        return new JsonResponse($model);
    }

    #[Route('/{village}/show', 'app_village_view')]
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
            'nonExistent' => $nonExistent,
            "villageId" => $village->getId()
        ]);
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