<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
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
     * Testing the task list as a user
     */
    public function testTaskListUser()
    {
        $crawler = $this->client->request('GET', '/tasks');
        static::assertEquals(1, $crawler->filter('a[href="/tasks/create"]')->count());
    }

    /**
     * Testing the task list as a admin
     */
    public function testTaskListAdmin()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => 'pass',
        ]);
        $crawler = $client->request('GET', '/tasks');
        static::assertEquals(1, $crawler->filter('a[href="/tasks/create"]')->count());
    }

    /**
     * Testing the task creation as a user
     */
    public function testTaskCreateByUser()
    {
        $crawler = $this->client->request('GET', '/tasks/create', array(), array(), array(
            'PHP_AUTH_USER' => 'alaina04',
            'PHP_AUTH_PW' => 'pass',
        ));
        $form = $crawler->filter('button[type="submit"]')->form();
        $form['task[title]'] = 'tachetest';
        $form['task[content]'] = 'tachetest';
        $this->client->submit($form);
        $crawler = $this->client->followRedirect();
        static::assertEquals(1, $crawler->filter(
            'html:contains("La tâche a été bien été ajoutée.")')->count());
    }

    /**
     * Testing the task creation as a admin
     */
    public function testTaskCreateByAdmin()
    {
        $crawler = $this->client->request('GET', '/tasks/create', array(), array(), array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => 'pass',
        ));
        $form = $crawler->filter('button[type="submit"]')->form();
        $form['task[title]'] = 'tachetest';
        $form['task[content]'] = 'tachetest';
        $this->client->submit($form);
        $crawler = $this->client->followRedirect();
        static::assertEquals(1, $crawler->filter(
            'html:contains("La tâche a été bien été ajoutée.")')->count());
    }

    /**
     * Testing the task edition as a user
     */
    public function testTaskEditByUser()
    {
        $crawler = $this->client->request('GET', '/tasks/157/edit', array(), array(), array(
            'PHP_AUTH_USER' => 'alaina04',
            'PHP_AUTH_PW' => 'pass',
        ));
        $form = $crawler->filter('button[type="submit"]')->form();
        $form['task[title]'] = 'essai';
        $form['task[content]'] = 'essai user';
        $this->client->submit($form);
        $crawler = $this->client->followRedirect();
        static::assertEquals(1, $crawler->filter('html:contains("modifiée.")')->count());
    }

    /**
     * Testing the task edition as a admin
     */
    public function testTaskEditByAdmin()
    {
        $crawler = $this->client->request('GET', '/tasks/162/edit', array(), array(), array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => 'pass',
        ));
        $form = $crawler->filter('button[type="submit"]')->form();
        $form['task[title]'] = 'test';
        $form['task[content]'] = 'test admin';
        $this->client->submit($form);
        $crawler = $this->client->followRedirect();
        static::assertEquals(1, $crawler->filter('html:contains("Supprimer")')->count());
    }

    /**
     * Testing the task edition as a user but no creator of the task
     */
    public function testTaskEditByUserNoOwner()
    {
        $crawler = $this->client->request('GET', '/tasks/157/edit', array(), array(), array(
            'PHP_AUTH_USER' => 'alaina04',
            'PHP_AUTH_PW' => 'pass',
        ));
        //$crawler = $this->client->followRedirect();
        static::assertEquals(0, $crawler->filter('html:contains("modifier")')->count());
    }

    /**
     * Testing the task deletion as a admin
     */
    public function testTaskDelete()
    {
        $this->client->request('GET', '/tasks/154/delete', array(), array(), array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => 'pass',
        ));

        $crawler = $this->client->followRedirect();
        static::assertEquals(1, $crawler->filter('html:contains("Supprimer")')->count());
    }

    /**
     * Testing the task deletion as a user but no creator of the task
     */
    public function testTaskDeleteByUserNoOwner()
    {
        $this->client->request('GET', '/tasks/159/delete', array(), array(), array(
            'PHP_AUTH_USER' => 'alaina04',
            'PHP_AUTH_PW' => 'pass',
        ));

        $crawler = $this->client->followRedirect();
        static::assertEquals(1, $crawler->filter('html:contains("La tâche ne vous appartient pas")')->count());
    }

    /**
     * Testing the task deletion as a user and creator of the task
     */
    public function testTaskDeleteByUser()
    {
        $this->client->request('GET', '/tasks/161/delete', array(), array(), array(
            'PHP_AUTH_USER' => 'alaina04',
            'PHP_AUTH_PW' => 'pass',
        ));

        $crawler = $this->client->followRedirect();
        static::assertEquals(1, $crawler->filter('html:contains("La tâche a bien été supprimée")')->count());
    }

    /**
     * Testing the task toggle off by admin
     */
    public function testTaskToggleOff()
    {
        $this->client->request('GET', '/tasks/154/toggle', array(), array(), array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => 'pass',
        ));
        $crawler = $this->client->followRedirect();

        static::assertSame(1, $crawler->filter('html:contains("Marquer comme faite")')->count());
    }

    /**
     * Testing the task toggle on by admin
     */
    public function testTaskToggleOn()
    {
        $this->client->request('GET', '/tasks/161/toggle', array(), array(), array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => 'pass',
        ));
        $crawler = $this->client->followRedirect();

        static::assertSame(1, $crawler->filter('html:contains("Marquer non terminée")')->count());
    }

    /**
     * Testing the task toggle off by user
     */
    public function testTaskToggleOffByUser()
    {
        $this->client->request('GET', '/tasks/161/toggle', array(), array(), array(
            'PHP_AUTH_USER' => 'alaina04',
            'PHP_AUTH_PW' => 'pass',
        ));
        $crawler = $this->client->followRedirect();

        static::assertSame(1, $crawler->filter('html:contains("Marquer comme faite")')->count());
    }

    /**
     * Testing the task toggle on by user
     */
    public function testTaskToggleOnByUser()
    {
        $this->client->request('GET', '/tasks/161/toggle', array(), array(), array(
            'PHP_AUTH_USER' => 'alaina04',
            'PHP_AUTH_PW' => 'pass',
        ));
        $crawler = $this->client->followRedirect();

        static::assertSame(1, $crawler->filter('html:contains("Marquer non terminée")')->count());
    }
}
