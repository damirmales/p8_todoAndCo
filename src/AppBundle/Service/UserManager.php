<?php


namespace AppBundle\Service;

use AppBundle\Entity\User;

/**
 * Class UserManager
 *
 * @package AppBundle\Service
 */
class UserManager
{
    /**
     * @var
     */
    private $entityManager;

    public function __construct($manager)
    {
        $this->entityManager = $manager;
    }

    /**
     * @param $role
     * @param User $user
     */
    public function setUserRole($role, User $user)
    {
        $user->setRole($role);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

}
