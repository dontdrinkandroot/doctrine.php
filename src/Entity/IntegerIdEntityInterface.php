<?php

namespace Dontdrinkandroot\Entity;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
interface IntegerIdEntityInterface extends EntityInterface
{
    /**
     * @return int
     */
    public function getId(): ?int;
}
