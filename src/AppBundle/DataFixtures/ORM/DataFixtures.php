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
        $admin->setUsername('toto');
        $admin->setPassword("toto");
        $admin->setEmail('toto@admin.fr ');
        $admin->setRole('ROLE_ADMIN');
        $manager->persist($admin);

        $allUsers= array();
        $password = 'pass';
        for ($i = 0; $i < 2; $i++) {
            $user = new User();
            array_push($allUsers, $user);
            $encoder = $this->container->get('security.password_encoder');
            $encoded = $encoder->encodePassword($user, $password);
            //add product to Customer
            $user->setUsername('customer' . $i)
                ->setEmail('email_' . $i . '@todo.fr')
                ->setRole('ROLE_USER')
                ->setPassword($encoded);

            $manager->persist($user);
        }

        for ($i = 0; $i < 20; $i++) {
            $task = new Task();
            //dump($task);die();
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