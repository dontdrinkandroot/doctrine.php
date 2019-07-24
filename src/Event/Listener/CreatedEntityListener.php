<?php

namespace Dontdrinkandroot\Event\Listener;

use DateTime;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Dontdrinkandroot\Entity\CreatedEntityInterface;
use Dontdrinkandroot\Entity\CreatedTimestampEntityInterface;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
class CreatedEntityListener
{
    public function prePersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getEntity();

        if (is_a($entity, CreatedEntityInterface::class)) {
            /** @var CreatedEntityInterface $createdEntity */
            $createdEntity = $entity;
            if (null === $createdEntity->getCreated()) {
                $createdEntity->setCreated(new DateTime());
            }
        }

        if (is_a($entity, CreatedTimestampEntityInterface::class)) {
            /** @var CreatedTimestampEntityInterface $createdTimestampEntity */
            $createdTimestampEntity = $entity;
            if (null === $createdTimestampEntity->getCreatedTimestamp()) {
                $createdTimestampEntity->setCreatedTimestamp((int)(microtime(true) * 1000));
            }
        }
    }
}
