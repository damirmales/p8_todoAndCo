<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Controller\TaskController;
use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use PHPUnit\Framework\TestCase;

class TaskControllerTUTest extends TestCase
{
    public function testSetUserFromCreateUserMethod(){
        $user = new User();
        $task = new Task();
        $task->setUser($user);
        $this->assertEquals($task->getUser(), $user);
    }


}
