<?php

namespace App\Service;

use App\Entity\Building;
use App\Entity\Enum\BuildingType;
use App\Entity\Enum\ResourceType;
use App\Entity\Resource;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class ResourceProcessor
{
    const UPDATE_INTERVAL = 1.0;

    private $resourceRepository;
    private EntityManagerInterface $entityManager;
    private LoggerInterface $logger;

    public function __construct(EntityManagerInterface $entityManager, LoggerInterface $logger)
    {
        $this->resourceRepository = $entityManager->getRepository(Resource::class);
        $this->entityManager = $entityManager;
        $this->logger = $logger;
    }

    public function process()
    {
        $resources = $this->resourceRepository->findAll();
        foreach ($resources as $resource) {
            $interval = microtime(true) - $resource->getUpdatedAt();
            if ($interval < self::UPDATE_INTERVAL) {
                continue;
            }
            $amount = $this->increaseResourceAmount($resource);
            $this->entityManager->persist($resource);

//            echo 'increased ' . $resource->getType()->value . ' by ' . round($amount) . PHP_EOL;
        }

        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    private function increaseResourceAmount(Resource $resource): float
    {
        $productivity = $this->getMineProductivity($resource);
        $now = microtime(true);
        $deltaTime = $now - $resource->getUpdatedAt();
        $resource->setUpdatedAt($now);
        $amount = $deltaTime * $productivity;
        $resource->addAmount($amount);

        return $amount;
    }

    private function getMineProductivity(Resource $resource): float
    {
        $buildingType = $this->getMineBuildingTypeByResourceType($resource->getType());
        $building = $this->entityManager->getRepository(Building::class)->findOneBy(['village' => $resource->getVillage(), 'type' => $buildingType]);
        $mineLevel = $building->getLevel();

        echo 'type ' . $resource->getType()->value . ' (' . $mineLevel . ') - ' . $this->getExponentialAmountPerHour($mineLevel) . PHP_EOL;

        return $this->getExponentialAmountPerHour($mineLevel) / 3600;
    }

    private function getExponentialAmountPerHour(int $level, float $factor = 0.5, int $base = 2): float
    {
        return round(pow($base, $level * $factor));
    }

    private function getMineBuildingTypeByResourceType(ResourceType $type): BuildingType
    {
        switch ($type) {
            case ResourceType::Wood:
                return BuildingType::WoodMine;
            case ResourceType::Iron:
                return BuildingType::IronMine;
            case ResourceType::Stone:
                return BuildingType::StoneMine;
            default:
                throw new \Exception('Could not find building type for resource ' . $type->value);
        }
    }
}