<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Controller\SecurityController;
//use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
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
    public function testLoginPage()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => 'admin',
        ]);
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form();
        $client->submit($form);

        $crawler = $client->followRedirect();
        $this->assertSame(1, $crawler->count());
        static::assertEquals(200, $client->getResponse()->getStatusCode());
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
