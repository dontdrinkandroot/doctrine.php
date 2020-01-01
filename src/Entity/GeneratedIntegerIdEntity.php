<?php

namespace Dontdrinkandroot\Entity;

use Doctrine\Common\Util\ClassUtils;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
class GeneratedIntegerIdEntity implements IntegerIdEntityInterface
{
    /** @var int */
    private $id;

    /**
     * {@inheritdoc}
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    public function isPersisted(): bool
    {
        return null !== $this->id;
    }

    /**
     * Checks if this entity represents the same entity as another one. Usually this is checked via the class and id.
     *
     * @param mixed $other
     *
     * @return bool
     */
    public function isSame($other): bool
    {
        if (null === $other || !is_object($other)) {
            return false;
        }

        $thisClass = ClassUtils::getRealClass(get_class($this));
        $otherClass = ClassUtils::getRealClass(get_class($other));

        if ($thisClass !== $otherClass) {
            return false;
        }

        /** @var EntityInterface $otherEntity */
        $otherEntity = $other;

        return $this->getId() === $otherEntity->getId();
    }
}
