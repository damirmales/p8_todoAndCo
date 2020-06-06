<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use AppBundle\Entity\Task;


use Doctrine\Common\Persistence\ObjectManager;


class AppFixtures  extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $genus = new User();
        $genus->setUsername('Octopus');
        $genus->setEmail('email_@todo.fr');
        $genus->setRole('ROLE_USER');
        $genus->setTasks(rand(100, 99999));
        $manager->persist($genus);
        $manager->flush();
    }

    public function method(): void
    {
        // TODO: Implement method() method.
    }
}