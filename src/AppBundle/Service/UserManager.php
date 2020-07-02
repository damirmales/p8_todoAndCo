<?php


namespace AppBundle\Service;

use AppBundle\Entity\User;

class UserManager
{
    private $entityManager;

    public function __construct($manager)
    {
        $this->entityManager = $manager;
    }

    public function setUserRole($role, User $user)
    {
        $user->setRole($role);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

}
