<?php

namespace Dontdrinkandroot\Event\Listener;

use DateTime;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Dontdrinkandroot\Entity\CreatedEntityInterface;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
class CreatedEntityListener
{
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (is_a($entity, CreatedEntityInterface::class)) {
            /** @var CreatedEntityInterface $createdEntity */
            $createdEntity = $entity;
            if (null === $createdEntity->getCreated()) {
                $createdEntity->setCreated(new DateTime());
            }
        }
    }
}
