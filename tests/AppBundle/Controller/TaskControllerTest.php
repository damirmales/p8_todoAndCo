<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\Task;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

//use Symfony\Bundle\SecurityBundle\Tests\Functional\WebTestCase;

//use Symfony\Bundle\FrameworkBundle\Tests\Functional\WebTestCase;

class TaskControllerTest extends WebTestCase
{

    public function testReturnListAction()
    {
        $client = static::createClient();
        $client->request('GET', '/');

        echo $client->getResponse()->getContent();

    }
}
