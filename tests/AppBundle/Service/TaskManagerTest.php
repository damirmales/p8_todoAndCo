<?php

namespace Tests\AppBundle\Service;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use AppBundle\Service\TaskManager;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class TaskManagerTest extends TestCase
{
    public function testTaskManager()
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $taskManager = new TaskManager($entityManager);
        $task = new Task();
        $user = new User();
        $taskManager->createTask($task, $user);
        $this->assertEquals($user, $task->getUser());
    }
}
