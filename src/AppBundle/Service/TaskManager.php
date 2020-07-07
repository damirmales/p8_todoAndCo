<?php


namespace AppBundle\Service;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;

/**
 * Class TaskManager
 *
 * @package AppBundle\Service
 */
class TaskManager
{
    private $entityManager;

    public function __construct($manager)
    {
        $this->entityManager = $manager;
    }

    /**
     * @param Task $task
     * @param User $user
     */
    public function createTask(Task $task, User $user)
    {
        $task->setUser($user);
        $this->entityManager->persist($task);
        $this->entityManager->flush();
    }
}
