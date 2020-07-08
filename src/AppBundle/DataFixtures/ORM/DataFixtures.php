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

        // create users
        $allUsers = array($anonym,$admin);
        $password = 'pass';
        for ($i = 0; $i < 2; $i++) {
            ${'user'.$i} = new User();
            array_push($allUsers,  ${'user'.$i});

            ${'user'.$i}->setUsername('customer' . $i)
                ->setEmail('email_' . $i . '@todo.fr')
                ->setRole('ROLE_USER')
                ->setPassword($password);
            $manager->persist(${'user'.$i});
        }

        for ($i = 0; $i < 2; $i++) {
            $task = new Task();
            //add admin to Task
            $task->setTitle('tâche-admin' . $i)
                ->setContent('cette tâche'. $i.' à faire' )
                ->setUser($admin)
                ->toggle(rand(0,1));
            $manager->persist($task);
        }

        for ($i = 0; $i < 2; $i++) {
            $task = new Task();
            //add anonym user to Task
            $task->setTitle('tâche existante' . $i)
                ->setContent('cette tâche'. $i.' à faire' )
                ->setUser($anonym)
                ->toggle(rand(0,1))
            ;
            $manager->persist($task);
        }

        for ($i = 0; $i < 2; $i++) {
            $task = new Task();
            //add User to Task
            $task->setTitle('tâche_user' . $i)
                ->setContent('cette tâche'. $i.' à faire' )
                ->setUser(${'user'.$i})
                ->toggle(rand(0,1))
            ;
            $manager->persist($task);
        }

        $manager->flush();
    }
}
