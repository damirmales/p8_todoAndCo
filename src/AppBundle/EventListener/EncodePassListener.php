<?php


namespace AppBundle\EventListener;


use AppBundle\Entity\User;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class EncodePassListener
{
   private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        // if this listener only applies to certain entity types,
        // add some code to check the entity type as early as possible
        if (!$entity instanceof User) {
            return;
        }

        $entityManager = $args->getObjectManager();
        $entity->setPassword($this->passwordEncoder->encodePassword(
            $entity,
            $entity->getPassword()
        ));

    }
  /*  public function prePersist(User $user, LifecycleEventArgs $event)
    {
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            $user->getPassword()
        ));
    }*/

}