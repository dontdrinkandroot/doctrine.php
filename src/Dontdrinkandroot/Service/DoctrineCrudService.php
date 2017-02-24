<?php

namespace Dontdrinkandroot\Service;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\PropertyAccess\PropertyAccess;

class DoctrineCrudService extends EntityRepository implements CrudServiceInterface
{
    /**
     * {@inheritdoc}
     */
    public function findAllPaginated(int $page = 1, int $perPage = 50): Paginator
    {
        $queryBuilder = $this->createQueryBuilder('entity');
        $queryBuilder->setFirstResult(($page - 1) * $perPage);
        $queryBuilder->setMaxResults($perPage);

        return new Paginator($queryBuilder);
    }

    protected function isUuid($id)
    {
        return 1 === preg_match('/^[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}$/', $id);
    }

    /**
     * {@inheritdoc}
     */
    public function create($entity)
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush($entity);

        return $entity;
    }

    /**
     * {@inheritdoc}
     */
    public function update($entity)
    {
        $this->getEntityManager()->flush($entity);

        return $entity;
    }

    /**
     * {@inheritdoc}
     */
    public function remove($entity)
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush($entity);
    }

    /**
     * {@inheritdoc}
     */
    public function findAssociationPaginated($entity, string $fieldName, int $page = 1, $perPage = 50)
    {
        $classMetadata = $this->getEntityManager()->getClassMetadata(get_class($entity));
        $targetClass = $classMetadata->getAssociationTargetClass($fieldName);

        $inverseFieldName = $this->getInverseFieldName($fieldName, $classMetadata);

        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder->select('association');
        $queryBuilder->from($targetClass, 'association');
        $queryBuilder->join('association.' . $inverseFieldName, 'entity');
        $queryBuilder->where('entity = :entity');
        $queryBuilder->setParameter('entity', $entity);

        $queryBuilder->setFirstResult(($page - 1) * $perPage);
        $queryBuilder->setMaxResults($perPage);

        $queryBuilder->getQuery();

        return new Paginator($queryBuilder);
    }

    /**
     * @param object     $entity
     * @param string     $fieldName
     * @param string|int $id
     */
    public function addToCollection($entity, string $fieldName, $id)
    {
        $classMetadata = $this->getEntityManager()->getClassMetadata(get_class($entity));
        $targetClass = $classMetadata->getAssociationTargetClass($fieldName);

        $inverseFieldName = $this->getInverseFieldName($fieldName, $classMetadata);

        $reference = $this->getEntityManager()->getReference($targetClass, $id);
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        $propertyAccessor->setValue($reference, $inverseFieldName, $entity);

        $this->getEntityManager()->flush($reference);
    }

    /**
     * @param object     $entity
     * @param string     $fieldName
     * @param string|int $id
     */
    public function removeFromCollection($entity, string $fieldName, $id)
    {
        $classMetadata = $this->getEntityManager()->getClassMetadata(get_class($entity));
        $targetClass = $classMetadata->getAssociationTargetClass($fieldName);

        $inverseFieldName = $this->getInverseFieldName($fieldName, $classMetadata);

        $reference = $this->getEntityManager()->getReference($targetClass, $id);
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        $propertyAccessor->setValue($reference, $inverseFieldName, null);

        $this->getEntityManager()->flush($reference);
    }

    /**
     * @param string        $fieldName
     * @param ClassMetadata $classMetadata
     *
     * @return string
     */
    public function getInverseFieldName(string $fieldName, ClassMetadata $classMetadata)
    {
        $association = $classMetadata->getAssociationMapping($fieldName);
        if ($classMetadata->isAssociationInverseSide($fieldName)) {
            return $association['mappedBy'];
        } else {
            return $association['inversedBy'];
        }
    }
}
