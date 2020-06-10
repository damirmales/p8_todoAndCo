<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    private $client = null;

    /**
     *
     */
    public function setUp(): void
    {
        $this->client = static::createClient([], [
            'PHP_AUTH_USER' => 'alaina04',
            'PHP_AUTH_PW' => 'pass',
        ]);
    }

    /**
     *
     */
    public function testTaskListUser()
    {
        $crawler = $this->client->request('GET', '/tasks');
        static::assertEquals(1, $crawler->filter('a[href="/tasks/create"]')->count());
    }

    /**
     *
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
     *
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
     *
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
     *
     */
    public function testTaskEditByUser()
    {
        $crawler = $this->client->request('GET', '/tasks/146/edit', array(), array(), array(
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
     *
     */
    public function testTaskEditByAdmin()
    {
        $crawler = $this->client->request('GET', '/tasks/129/edit', array(), array(), array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => 'pass',
        ));
        $form = $crawler->filter('button[type="submit"]')->form();
        $form['task[title]'] = 'test';
        $form['task[content]'] = 'test admin';
        $this->client->submit($form);
        $crawler = $this->client->followRedirect();
        static::assertEquals(1, $crawler->filter('html:contains("modifiée.")')->count());
    }

    public function testTaskEditByUserNoOwner()
    {
        $crawler = $this->client->request('GET', '/tasks/129/edit', array(), array(), array(
            'PHP_AUTH_USER' => 'alaina04',
            'PHP_AUTH_PW' => 'pass',
        ));
        //$crawler = $this->client->followRedirect();
        static::assertEquals(0, $crawler->filter('html:contains("modifier")')->count());
    }

    public function testTaskDelete()
    {
        $this->client->request('GET', '/tasks/145/delete', array(), array(), array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => 'pass',
        ));

        $crawler = $this->client->followRedirect();
        static::assertEquals(1, $crawler->filter('html:contains("La tâche a bien été supprimée")')->count());
    }

    public function testTaskDeleteByUserNoOwner()
    {
        $this->client->request('GET', '/tasks/129/delete', array(), array(), array(
            'PHP_AUTH_USER' => 'alaina04',
            'PHP_AUTH_PW' => 'pass',
        ));

        $crawler = $this->client->followRedirect();
        static::assertEquals(1, $crawler->filter('html:contains("La tâche ne vous appartient pas")')->count());
    }

    public function testTaskDeleteByUser()
    {
        $this->client->request('GET', '/tasks/141/delete', array(), array(), array(
            'PHP_AUTH_USER' => 'alaina04',
            'PHP_AUTH_PW' => 'pass',
        ));

        $crawler = $this->client->followRedirect();
        static::assertEquals(1, $crawler->filter('html:contains("La tâche a bien été supprimée")')->count());
    }

    public function testTaskToggleOff()
    {
        $this->client->request('GET', '/tasks/129/toggle', array(), array(), array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => 'pass',
        ));
        $crawler = $this->client->followRedirect();

        static::assertSame(1, $crawler->filter('html:contains("Marquer comme faite")')->count());
    }

    public function testTaskToggleOn()
    {
        $this->client->request('GET', '/tasks/129/toggle', array(), array(), array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => 'pass',
        ));
        $crawler = $this->client->followRedirect();

        static::assertSame(1, $crawler->filter('html:contains("Marquer non terminée")')->count());
    }
}
