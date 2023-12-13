<?php

namespace App\DataFixtures;

use App\Entity\Player;
use App\Entity\Village;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    const TEST_USER_NAME = 'test1';

    public function load(ObjectManager $manager): void
    {
        $testUser = $manager->getRepository(Player::class)->findOneBy(['name'=> self::TEST_USER_NAME]);

        if ($testUser && $testUser->getVillages()->count() >= 1) {
            return;
        }

        if ($testUser && $testUser->getVillages()->count() === 0) {
            $village = new Village($testUser);
            $manager->persist($village);
            $manager->flush();
            return;
        }

        $testUser = new Player(self::TEST_USER_NAME);
        $village = new Village($testUser);
        $manager->persist($testUser);
        $manager->persist($village);

        $manager->flush();
    }
}
