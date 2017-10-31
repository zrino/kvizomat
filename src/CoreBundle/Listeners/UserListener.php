<?php
namespace CoreBundle\Listeners;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use CoreBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

class UserListener implements EventSubscriber
{
    private $encoder;

    public function __construct(UserPasswordEncoder $encoder)
    {
        $this->encoder = $encoder;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $object = $args->getEntity();

        // only act on some "Product" entity
        if (!$object instanceof User) {
            return;
        }

        $this->encodePassword($object);
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $object = $args->getEntity();

        // only act on some "Product" entity
        if (!$object instanceof User) {
            return;
        }

        $this->encodePassword($object);

        $em = $args->getEntityManager();
        $meta = $em->getClassMetadata(get_class($object));
        $em->getUnitOfWork()->recomputeSingleEntityChangeSet($meta, $object);

    }

    /**
     * @param User $entity
     */
    private function encodePassword(User $entity)
    {
        $encoded = $this->encoder->encodePassword($entity, $entity->getPlainPassword());
        $entity->setPassword($encoded);
    }

    public function getSubscribedEvents()
    {
        return [
            'prePersist',
            'preUpdate'
        ];
    }
}