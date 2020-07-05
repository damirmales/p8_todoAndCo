<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\Task;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TaskControllerTest
 * @package Tests\AppBundle\Controller
 */
class TaskControllerTest extends WebTestCase
{

    /**
     * @return \Symfony\Bundle\FrameworkBundle\KernelBrowser
     */
    public function useUser(){

    $client = static::createClient([], [
        'PHP_AUTH_USER' => 'customer0',
        'PHP_AUTH_PW' => 'pass',
    ]);
    return $client;
}

    /**
     * @return \Symfony\Bundle\FrameworkBundle\KernelBrowser
     */
    public function useAdmin(){

        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => 'admin',
        ]);
        return $client;
    }


    /**
     * Testing the task list as a user
     */
    public function testTaskListUser()
    {
        $client = $this->useUser();
        $crawler = $client->request('GET', '/tasks');
        static::assertEquals(1, $crawler->filter('a[href="/tasks/create"]')->count());
    }

    /**
     * Testing the task list as a admin
     */
    public function testTaskListAdmin()
    {
        $client = $this->useAdmin();
        $crawler = $client->request('GET', '/tasks');
        static::assertEquals(1, $crawler->filter('a[href="/tasks/create"]')->count());
    }

    /**
     * Testing the task creation as a user
     */
    public function testTaskCreateByUser()
    {
        $client = $this->useUser();
        $crawler = $client->request('GET', '/tasks/create');
        $form = $crawler->filter('button[type="submit"]')->form();
        $form['task[title]'] = 'tachetest';
        $form['task[content]'] = 'tachetest user';
        $client->submit($form);
        $crawler = $client->followRedirect();
        static::assertEquals(1, $crawler->filter(
            'html:contains("La tâche a été bien été ajoutée.")')->count());
    }

    /**
     * Testing the task creation as a admin
     */
    public function testTaskCreateByAdmin()
    {
        $client = $this->useAdmin();
        $crawler = $client->request('GET', '/tasks/create');
        $form = $crawler->filter('button[type="submit"]')->form();
        $form['task[title]'] = 'tachetest';
        $form['task[content]'] = 'tachetest admin';
        $client->submit($form);
        $crawler = $client->followRedirect();
        static::assertEquals(1, $crawler->filter(
            'html:contains("La tâche a été bien été ajoutée.")')->count());
    }

    /**
     * Testing the task edition as a user
     */
    public function testTaskEditByUser()
    {
        $client = $this->useUser();
        $crawler = $client->request('GET', '/tasks/2/edit');
        $form = $crawler->selectButton( 'Modifier' )->form();
        $form['task[title]'] = 'essai';
        $form['task[content]'] = 'essai user customer0';
        $client->submit($form);
        $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

    }

    /**
     * Testing the task edition as admin
     */
    public function testTaskEditByAdmin()
    {
        $client = $this->useAdmin();
        $crawler = $client->request('GET', '/tasks/2/edit');
        $form = $crawler->filter('button[type="submit"]')->form();
        $form['task[title]'] = 'test';
        $form['task[content]'] = 'test admin';
        $client->submit($form);
        $crawler = $client->followRedirect();
        static::assertEquals(1, $crawler->filter(
            'html:contains("modifiée")')->count());
    }

    /**
     * Testing the task edition as a user but no creator of the task
     */
    public function testTaskEditByUserNoOwner()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'customer1',
            'PHP_AUTH_PW' => 'pass',
        ]);
        $crawler = $client->request('GET', '/tasks/2/edit');
        $form = $crawler->filter('form')->form();
        $form['task[title]'] = 'test';
        $form['task[content]'] = 'test customer1';
        $client->submit($form);
        $crawler = $client->followRedirect();

        static::assertEquals(0, $crawler->filter('html:contains("modifier")')->count());
    }


    /**
     * Testing the task deletion as a admin
     */
    public function testTaskDeleteByAdmin()
    {
        $client = $this->useAdmin();
        $crawler = $client->request('GET', '/tasks');
        $form = $crawler->selectButton( 'Supprimer' )->last()->form();
        $client->submit( $form );
        $crawler = $client->followRedirect();
       static::assertEquals(1, $crawler->filter('html:contains("Supprimer")')->count());
    }

    /**
     * Testing the task deletion as a user but no creator of the task
     */
    public function testTaskDeleteByUserNoOwner()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'customer1',
            'PHP_AUTH_PW' => 'pass',
        ]);
        $crawler = $client->request('GET', '/tasks');
        $form = $crawler->selectButton( 'Supprimer' )->last()->form();
        $client->submit( $form );
        $crawler = $client->followRedirect();
        static::assertEquals(1, $crawler->filter(
            'html:contains("La tâche ne vous appartient pas.")')->count());
    }

    /**
     * Testing the task deletion as a user and creator of the task
     */
    public function testTaskDeleteByUserOwner()
    {
        $client = $this->useUser();
        $crawler =  $client->request('GET', '/tasks');
        $form = $crawler->selectButton( 'Supprimer' )->last()->form();
        $client->submit( $form );
        $crawler = $client->followRedirect();
        static::assertEquals(1, $crawler->filter('html:contains("La tâche a bien été supprimée")')->count());
    }

    /**
     * Testing the task toggle off by user
     */
    public function testTaskToggleOffByUser()
    {
        $client = $this->useUser();
        $crawler = $client->request('GET', '/tasks');
        $crawler->selectButton('Marquer non terminée')->form();
        static::assertSame(1, $crawler->filter('html:contains("Marquer comme faite")')->count());
    }

    /**
     * Testing the task toggle on by user
     */
    public function testTaskToggleOnByUser()
    {
        $client = $this->useUser();
        $crawler = $client->request('GET', '/tasks');
        $crawler->selectButton('Marquer comme faite')->form();

        static::assertSame(1, $crawler->filter('html:contains("Marquer non terminée")')->count());
    }

}