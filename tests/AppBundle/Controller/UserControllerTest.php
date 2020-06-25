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
            'PHP_AUTH_USER' => 'customer0',
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
            'PHP_AUTH_PW' => 'admin',
        ]);
        $client->request('GET', '/users');
        static::assertEquals(200, $client->getResponse()->getStatusCode());

    }

    /**
     * Testing the user creation as a user
     */
    public function testUserCreateByUser()
    {
        $this->client->request('GET', '/users');
        static::assertEquals(403, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Testing the user creation as a admin
     */
    public function testUserCreateByAdmin()
    {
        $client = static::createClient([], ['PHP_AUTH_USER' => 'admin', 'PHP_AUTH_PW' => 'admin']);
        $crawler = $client->request('GET', '/users/create');
        $buttonCrawlerAddUser = $crawler->selectButton('Ajouter');
        $formUser = $buttonCrawlerAddUser->form();
        $client->submit($formUser, [
            'user[username]' => 'username' . rand(0, 10000),
            'user[password][first]' => 'pass',
            'user[password][second]' => 'pass',
            'user[email]' => rand(0, 10000) . 'email@ff.fr',
            'user[role]' => 'ROLE_USER'
        ]);

        $client->followRedirect();
        $this->assertTrue($client->getResponse()->isSuccessful(), 'L\'utilisateur a bien été ajouté');
    }

    /**
     * Testing the user edition as a user
     */
    public function testUserEditByUser()
    {
        $this->client->request('GET', '/users');
        static::assertEquals(403, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Testing the user edition as a admin
     */
    public function testUserEditByAdmin()
    {
        $client = static::createClient([], ['PHP_AUTH_USER' => 'admin', 'PHP_AUTH_PW' => 'admin']);

        $crawler = $client->request('GET', '/users');
        $link = $crawler->selectLink('Edit')->last()->link();
        $crawler = $client->click($link);

        $form = $crawler->selectButton('Modifier')->form();
        $form['user[username]'] = 'newuser';
        $form['user[password][first]'] = 'pass';
        $form['user[password][second]'] = 'pass';
        $form['user[email]'] = 'newuser@fr.fr';
        $form['user[role]'] = 'ROLE_ADMIN';
        $client->submit($form);

        $this->assertTrue($client->getResponse()->isSuccessful(), 'L\'utilisateur a bien été modifié');
    }
}