<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private $user;
    public function setUp(): void
    {
        $this->user = new User();
    }

    public function testUsername(){

        $this->user->setUsername("Emma");
        $this->assertEquals($this->user->getUsername(), "Emma");
    }

    public function testRole(){

        $this->user->setRole("ROLE_USER");
        $this->assertEquals($this->user->getRole(), "ROLE_USER");
    }

    public function testPassword(){

        $this->user->setPassword("helloDolly");
        $this->assertEquals($this->user->getPassword(), "helloDolly");
    }

    public function testTasks()
    {
        $task = new Task();

        $this->user->setTasks($task);
        $this->assertEquals($this->user->getTasks(), $task);
    }
}
