<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Doctrine\Common\Collections\Collection;

class UserTest extends TestCase
{
    /**
     * @var User
     */
    private $user;

    private $task;

    /**
     *
     */
    public function setUp(): void
    {
        $this->user = new User();

        $this->task = new Task();
    }


    public function testIdIsNull()
    {
        $this->assertNull($this->user->getId());
    }

    /**
     *
     */
    public function testUsername(){

        $this->user->setUsername("Emma");
        $this->assertEquals($this->user->getUsername(), "Emma");
    }

    /**
     *
     */
    public function testRole(){

        $this->user->setRole("ROLE_USER");
        $this->assertEquals($this->user->getRole(), "ROLE_USER");
    }

    /**
     *
     */
    public function testPassword(){

        $this->user->setPassword("helloDolly");
        $this->assertEquals($this->user->getPassword(), "helloDolly");
    }

    /**
     *
     */
    public function testTasks()
    {
$tasks = new ArrayCollection();
       // $this->user->setTasks($tasks);
        $this->assertEquals($this->user->getTasks(), $tasks);
    }

    /**
     *
     */
    public function testEmail()
    {
        $this->user->setEmail("Emma@gg.ff");
        $this->assertEquals($this->user->getEmail(), "Emma@gg.ff");
    }

    public function testAddTaskIsOk()
    {
        $tasks = new ArrayCollection();
        $this->user->setTasks($tasks);
        $this->user->addTask($this->task);

        $this->assertCount(1, $this->user->getTasks());
    }

    public function testRemoveTaskIsOk()
    {
        $tasks = new ArrayCollection();
       $this->user->setTasks($tasks);
        $this->user->addTask($this->task);

        $this->user->removeTask($this->task);
        $this->assertCount(0, $this->user->getTasks());
    }

    public function testEraseCredenttials()
    {
        $eraseCredentials = $this->user->eraseCredentials();
        self::assertNull( $eraseCredentials );
    }
}