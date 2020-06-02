<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\Task;
use PHPUnit\Framework\TestCase;

class TaskControllerTest extends TestCase
{

    public function testReturnListAction()
    {
        $task = new Task();
        $task->setTitle("tache");
        $task->setContent("tache sachant tacher");
        $task->setCreatedAt(2020-05-29);
        $task->setUser("bil");

        $this->assertEquals($task->getTitle(),"tache");
        $this->assertEquals($task->getContent(),"tache sachant tacher");
        $this->assertEquals($task->getCreatedAt(),2020-05-29);
        $this->assertEquals($task->getUser(),"bil");
    }
}
