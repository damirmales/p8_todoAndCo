<?php

namespace Tests\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class DefaultControllerTest extends WebTestCase
{
    /**
     * @var \Symfony\Bundle\FrameworkBundle\KernelBrowser|null
     */
    private $client = null;

    /**
     *
     */
    public function setUp():void
    {
        $this->client = static::createClient([], [
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => 'admin',
        ]);
    }

    /**
     *
     */
    public function testIndex()
    {
        $this->client ->request('GET', '/');

        static::assertEquals(200, $this->client ->getResponse()->getStatusCode());

    }
}
