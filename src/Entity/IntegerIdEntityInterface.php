<?php

namespace Dontdrinkandroot\Entity;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
interface IntegerIdEntityInterface extends EntityInterface
{
    public function getId(): ?int;
}
