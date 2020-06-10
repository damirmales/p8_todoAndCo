<?php

namespace Tests\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class DefaultControllerTest extends WebTestCase
{
    private $client = null;

    public function setUp():void
    {
        $this->client = static::createClient([], [
            'PHP_AUTH_USER' => 'alaina04',
            'PHP_AUTH_PW'   => 'pass',
        ]);
    }

    public function testIndex()
    {

        $this->client ->request('GET', '/');

        static::assertEquals(200, $this->client ->getResponse()->getStatusCode());

    }
}
