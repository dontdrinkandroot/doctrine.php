<?php

namespace Dontdrinkandroot\Event\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Dontdrinkandroot\Entity\UuidEntityInterface;
use Ramsey\Uuid\Uuid;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
class UuidEntityListener
{
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (is_a($entity, UuidEntityInterface::class)) {
            /** @var UuidEntityInterface $uuidEntity */
            $uuidEntity = $entity;
            if (null === $uuidEntity->getUuid()) {
                $uuidEntity->setUuid(Uuid::uuid4()->toString());
            }
        }
    }
}
