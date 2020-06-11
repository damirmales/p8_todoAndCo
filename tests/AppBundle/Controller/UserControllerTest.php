<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{

    private $client = null;

    /**
     * Create HTTP client
     */
    public function setUp(): void
    {
        $this->client = static::createClient([], [
            'PHP_AUTH_USER' => 'alaina04',
            'PHP_AUTH_PW' => 'pass',
        ]);
    }

    /**
     * Testing the user list as a user
     */
    public function testUserListUser()
    {
        $this->client->request('GET', '/users');
        static::assertEquals(403, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Testing the user list as a admin
     */
    public function testUserListAdmin()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => 'pass',
        ]);
        $crawler = $client->request('GET', '/users');
        static::assertEquals(1, $crawler->filter('a[href="/users/create"]')->count());
    }

    /**
     * Testing the user creation as a user
     */
    public function testUserCreateByUser()
    {
        $this->client->request('GET', '/users/create', array(), array(), array(
            'PHP_AUTH_USER' => 'alaina04',
            'PHP_AUTH_PW' => 'pass',
        ));
        static::assertEquals(403, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Testing the user creation as a admin
     */
    public function testUserCreateByAdmin()
    {
        $crawler = $this->client->request('GET', '/users/create', array(), array(), array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => 'pass',
        ));

        $buttonCrawlerAddUser = $crawler->selectButton('Ajouter');
        $formUser = $buttonCrawlerAddUser->form();
        $this->client->submit($formUser, [
            'user[username]' => 'username'.rand(0, 10000),
            'user[password][first]' => 'pass',
            'user[password][second]' => 'pass',
            'user[email]' => rand(0, 10000).'email@ff.fr',
            'user[role]' => 'ROLE_USER'
        ]);
        static::assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Testing the user edition as a user
     */
    public function testUserEditByUser()
    {
        $this->client->request('GET', '/users/72/edit', array(), array(), array(
            'PHP_AUTH_USER' => 'alaina04',
            'PHP_AUTH_PW' => 'pass',
        ));
        static::assertEquals(403, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Testing the user edition as a admin
     */
    public function testUserEditByAdmin()
    {
        $crawler = $this->client->request('GET', '/users/75/edit', array(), array(), array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => 'pass',
        ));
        $form = $crawler->filter('button[type="submit"]')->form();
        $form['user[username]'] = 'Svetla';
        $form['user[email]'] = 'svet@rus.fr';
        $form['user[role]'] = 'ROLE_USER';
        $form['user[password][first]'] = 'pass';
        $form['user[password][second]'] = 'pass';
        $this->client->submit($form);

        $crawler = $this->client->followRedirect();
        static::assertEquals(1, $crawler->filter('html:contains("modifiée.")')->count());
    }
}