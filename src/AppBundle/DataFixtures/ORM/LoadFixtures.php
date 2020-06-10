<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use Nelmio\Alice\Fixtures;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LoadFixtures extends Controller implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $objects = Fixtures::load(
            __DIR__ . DIRECTORY_SEPARATOR . 'fixtures.yaml',
            $manager,
            [
                'providers' => [$this]
            ]
        );
    }

    public function title()
    {
        $genera = [
            'Octopus',
            'Balaena',
            'Orcinus',
            'Hippocampus',
            'Asterias',
            'Amphiprion',
            'Carcharodon',
            'Aurelia',
            'Cucumaria',
            'Balistoides',
            'Paralithodes',
            'Chelonia',
            'Trichechus',
            'Eumetopias'
        ];

        $key = array_rand($genera);

        return $genera[$key];
    }


    public function password()
    {
        $user = new User();
        $password = $this->get('security.password_encoder')->encodePassword($user, 'pass');

        return $password;
    }
}
