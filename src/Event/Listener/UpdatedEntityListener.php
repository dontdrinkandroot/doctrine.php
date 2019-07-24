<?php

namespace Dontdrinkandroot\Event\Listener;

use DateTime;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Dontdrinkandroot\Entity\UpdatedEntityInterface;
use Dontdrinkandroot\Entity\UpdatedTimestampEntityInterface;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
class UpdatedEntityListener
{
    public function prePersist(LifecycleEventArgs $args): void
    {
        $this->checkAndSetUpdated($args);
    }

    public function preUpdate(LifecycleEventArgs $args): void
    {
        $this->checkAndSetUpdated($args);
    }

    protected function checkAndSetUpdated(LifecycleEventArgs $args): void
    {
        $entity = $args->getEntity();

        if (is_a($entity, UpdatedEntityInterface::class)) {
            /** @var UpdatedEntityInterface $updatedEntity */
            $updatedEntity = $entity;
            $updatedEntity->setUpdated(new DateTime());
        }

        if (is_a($entity, UpdatedTimestampEntityInterface::class)) {
            /** @var UpdatedTimestampEntityInterface $updatedTimestampEntity */
            $updatedTimestampEntity = $entity;
            if (null === $updatedTimestampEntity->getUpdatedTimestamp()) {
                $updatedTimestampEntity->setUpdatedTimestamp((int)(microtime(true) * 1000));
            }
        }
    }
}
