<?php

namespace Dontdrinkandroot\Entity;

/**
 * @Entity(repositoryClass="Dontdrinkandroot\Repository\AssignedIdExampleEntityRepository")
 * @Table(name="AssignedIdExampleEntity")
 */
class AssignedIdExampleEntity implements EntityInterface
{

    /**
     * @Id
     * @Column(type="integer")
     * @var int
     */
    protected $id;

    /**
     * @Column(type="string")
     * @var string
     */
    protected $name;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}
