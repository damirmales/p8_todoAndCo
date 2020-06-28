<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

class DataFixtures extends Fixture
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @param ContainerInterface|null $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $admin = new User();
        $admin->setUsername('admin')
            ->setPassword("admin")
            ->setEmail('admin@admin.fr ')
            ->setRole('ROLE_ADMIN');
        $manager->persist($admin);

        $anonym = new User();
        $anonym->setUsername('anonym')
            ->setPassword("anonym")
            ->setEmail('anonymo@admin.fr ')
            ->setRole('ROLE_USER');
        $manager->persist($anonym);

        $allUsers = array($anonym);
        $password = 'pass';
        for ($i = 0; $i < 2; $i++) {
            $user = new User();
            array_push($allUsers, $user);
            //add product to Customer
            $user->setUsername('customer' . $i)
                ->setEmail('email_' . $i . '@todo.fr')
                ->setRole('ROLE_USER')
                ->setPassword($password);
            $manager->persist($user);
        }

        for ($i = 0; $i < 10; $i++) {
            $task = new Task();
            $randUser = shuffle($allUsers); //define a randomly user to add to a task
            //add User to Task
            $task->setTitle('bill_' . $i)
                ->setContent('hobbes_' . $i)
                ->setUser($allUsers[$randUser]);
            $manager->persist($task);
        }
        $manager->flush();
    }
}
