<?php

namespace App\Api\Factory;

use App\Api\Model\Resource\Resource as ResourceApiModel;
use App\Entity\Resource as ResourceEntity;
use App\Entity\Village;
use Doctrine\ORM\EntityManagerInterface;

class ResourcesGetRequestFactory
{
    private $resourceRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->resourceRepository = $entityManager->getRepository(ResourceEntity::class);
    }

    /**
     * @param int $villageId
     * @return Resource[]
     */
    public function create(Village $village): array
    {
        $resources = [];
        $entities = $this->resourceRepository->findBy(['village' => $village]);
        foreach ($entities as $entity) {
            $resources[] = new ResourceApiModel($entity->getType()->value, $entity->getAmount());
        }

        return $resources;
    }
}
