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

    public function __construct()
    {
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function isPersisted()
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
    public function isSame($other)
    {
        if (null === $other || !is_object($other)) {
            return false;
        }

        $thisClass = ClassUtils::getRealClass(get_class($this));
        $otherClass = ClassUtils::getRealClass(get_class($other));

        if (!$thisClass === $otherClass) {
            return false;
        }

        /** @var AbstractEntity $otherEntity */
        $otherEntity = $other;

        return $this->getId() === $otherEntity->getId();
    }
}
