<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = (new User);
        $user->setPhone('+380000000000');
        $user->setPassword('pass');
        $user->setSurname('surName');
        $user->setFirstName('firstNAme');
        $manager->persist($user);
        $manager->flush();

        $user = (new User);
        $user->setPhone('+380000000001');
        $user->setPassword('pass');
        $user->setSurname('surName1');
        $user->setFirstName('firstNAme1');
        $manager->persist($user);
        $manager->flush();

        $user = (new User);
        $user->setPhone('+380000000002');
        $user->setPassword('pass2');
        $user->setSurname('surName2');
        $user->setFirstName('firstNAme2');
        $manager->persist($user);
        $manager->flush();

        $user = (new User);
        $user->setPhone('+380000000003');
        $user->setPassword('pass3');
        $user->setSurname('surName3');
        $user->setFirstName('firstNAme3');
        $manager->persist($user);
        $manager->flush();

        $manager->flush();
    }
}
