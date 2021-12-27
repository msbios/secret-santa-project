<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i < 50; $i++) {
            $user = (new User);
            $user->setPhone('+3800000000' . $i);
            $user->setPassword('pass' . $i);
            $user->setSurname('surName' . $i);
            $user->setFirstName('firstNAme' . $i);
            $manager->persist($user);
            $manager->flush();
        }
    }
}
