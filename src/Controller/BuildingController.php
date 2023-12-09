<?php

namespace App\Controller;

use App\Api\Model\Building\CreateBuildingDto;
use App\Api\Model\Building\LevelUpBuildingDto;
use App\Entity\Building;
use App\Entity\Enum\BuildingType;
use App\Entity\Village;
use App\HttpFoundation\NoContentResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/building', name: 'app_building_')]
class BuildingController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'create', methods: Request::METHOD_POST)]
    public function create(
        #[MapRequestPayload] CreateBuildingDto $body
    ): Response
    {
        $village = $this->entityManager->getRepository(Village::class)->find($body->villageId);

        if (!$village) {
            throw new BadRequestException("Village with id {$village->getId()} not found");
        }

        $building = new Building(BuildingType::from($body->buildingType), $village, 1);
        $this->entityManager->persist($building);
        $this->entityManager->flush();

        return new NoContentResponse();
    }

    #[Route('/up', name: 'up', methods: Request::METHOD_POST)]
    public function up(
        #[MapRequestPayload] LevelUpBuildingDto $body
    ): Response
    {
        $building = $this->entityManager->find(Building::class, $body->buildingId);

        if (!$building) {
            throw new BadRequestException("Building with id {$building->getId()} not found");
        }

        $building->addLevel(1);

        $this->entityManager->persist($building);
        $this->entityManager->flush();

        return new NoContentResponse();
    }
}