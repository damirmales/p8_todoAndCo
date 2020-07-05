<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Controller\SecurityController;
use PHPUnit\Framework\TestCase;

class SecurityControllerTest extends TestCase
{
    /**
     * @var SecurityController
     */
    protected $controller;

    /**
     *
     */
    public function setUp():void
    {
        $this->controller = new SecurityController();
    }

    /**
     *
     */
    public function testLoginCheck()
    {
        $check = $this->controller->loginCheck();
        self::assertNull( $check );
    }

    /**
     *
     */
    public function testLogout()
    {
        $check = $this->controller->logoutCheck();
        self::assertNull( $check );
    }

}
