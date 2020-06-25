<?php

namespace Tests\AppBundle\Service;

use AppBundle\Entity\User;
use AppBundle\Service\UserManager;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class UserManagerTest extends TestCase
{
    public function testSetUserRoleAsRole_User()
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $userManager = new UserManager($entityManager);
        $role = 'ROLE_USER';
        $user = new User();
        $userManager->setUserRole($role, $user);
        $this->assertEquals($role, $user->getRole());

    }


}
