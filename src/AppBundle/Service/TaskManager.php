<?php


namespace AppBundle\Service;


use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;

class TaskManager
{
    private $entityManager;

    public function __construct($manager)
    {
        $this->entityManager = $manager;
    }

    public function createTask(Task $task, User $user)
    {
        $task->setUser($user);
        $this->entityManager->persist($task);
        $this->entityManager->flush();
    }
}