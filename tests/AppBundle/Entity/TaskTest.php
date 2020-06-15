<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Task;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    private $task;
    public function setUp(): void
{
    $this->task = new Task();
}

    public function testTitle(){

        $this->task->setTitle("tache");
        $this->assertEquals($this->task->getTitle(), "tache");
    }

    public function testContent(){

        $this->task->setContent("tache sachant tacher");
        $this->assertEquals($this->task->getContent(), "tache sachant tacher");
    }

    public function testCreatedAt(){

        $this->task->setCreatedAt(2020-05-29);
        $this->assertEquals($this->task->getCreatedAt(), 2020-05-29);
    }

    public function testUser(){

        $this->task->setUser("bil");
        $this->assertEquals($this->task->getUser(), "bil");
    }

    public function testIsDone(){
        $this->task->toggle(true);
        $this->assertEquals($this->task->IsDone(), 1);
    }
}
