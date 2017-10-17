<?php

namespace Dontdrinkandroot\Service;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Dontdrinkandroot\Repository\TransactionManager;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\PropertyAccess\PropertyAccess;

class DoctrineCrudService extends EntityRepository implements CrudServiceInterface
{
    /**
     * @var  LoggerInterface
     */
    private $logger;

    /**
     * @var TransactionManager
     */
    private $transactionManager;

    /**
     * DoctrineCrudService constructor.
     *
     * @param EntityManager        $em
     * @param ClassMetadata|string $class
     */
    public function __construct(EntityManager $em, $class)
    {
        $classMetaData = $class;
        if (is_string($classMetaData)) {
            $classMetaData = $em->getClassMetadata($classMetaData);
        }
        parent::__construct($em, $classMetaData);
        $this->transactionManager = new TransactionManager($em);
    }

    /**
     * {@inheritdoc}
     */
    public function findAllPaginated(int $page = 1, int $perPage = 50): Paginator
    {
        $queryBuilder = $this->createFindAllQueryBuilder();
        $queryBuilder->setFirstResult(($page - 1) * $perPage);
        $queryBuilder->setMaxResults($perPage);

        return new Paginator($queryBuilder);
    }

    protected function createFindAllQueryBuilder(): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder('entity');

        return $queryBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function create($entity, bool $flush = true)
    {
        $this->getEntityManager()->persist($entity);
        if ($flush) {
            $this->getEntityManager()->flush($entity);
        }

        return $entity;
    }

    /**
     * {@inheritdoc}
     */
    public function update($entity, bool $flush = false)
    {
        if ($flush || $this->isVersioned($entity)) {
            $this->getEntityManager()->flush($entity);
        }

        return $entity;
    }

    protected function isVersioned($entity)
    {
        $classMetadata = $this->getEntityManager()->getClassMetadata(get_class($entity));

        return $classMetadata->isVersioned;
    }

    /**
     * {@inheritdoc}
     */
    public function remove($entity, bool $flush = false)
    {
        $this->getEntityManager()->remove($entity);
        if ($flush) {
            $this->getEntityManager()->flush($entity);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function findAssociationPaginated($entity, string $fieldName, int $page = 1, $perPage = 50)
    {
        $classMetadata = $this->getEntityManager()->getClassMetadata(get_class($entity));
        $association = $classMetadata->associationMappings[$fieldName];
        $targetClass = $classMetadata->getAssociationTargetClass($fieldName);
        $inverseFieldName = $this->getInverseFieldName($fieldName, $classMetadata);

        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder->select('association');
        $queryBuilder->from($targetClass, 'association');
        $queryBuilder->join('association.' . $inverseFieldName, 'entity');
        $queryBuilder->where('entity = :entity');

        if (array_key_exists('orderBy', $association)) {
            $orderBy = $association['orderBy'];
            foreach ($orderBy as $fieldName => $order) {
                $queryBuilder->addOrderBy('association.' . $fieldName, $order);
            }
        }

        $queryBuilder->setParameter('entity', $entity);

        $queryBuilder->setFirstResult(($page - 1) * $perPage);
        $queryBuilder->setMaxResults($perPage);

        return new Paginator($queryBuilder);
    }

    /**
     * {@inheritdoc}
     */
    public function createAssociation($entity, string $fieldName, $associatedEntity)
    {
        $classMetadata = $this->getEntityManager()->getClassMetadata(get_class($entity));

        $inverseFieldName = $this->getInverseFieldName($fieldName, $classMetadata);
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        $propertyAccessor->setValue($associatedEntity, $inverseFieldName, $entity);

        $this->getEntityManager()->persist($associatedEntity);
        $this->getEntityManager()->flush($associatedEntity);

        return $associatedEntity;
    }

    /**
     * {@inheritdoc}
     */
    public function addAssociation($entity, string $fieldName, $id)
    {
        $classMetadata = $this->getEntityManager()->getClassMetadata(get_class($entity));
        $collection = $classMetadata->isCollectionValuedAssociation($fieldName);
        $targetClass = $classMetadata->getAssociationTargetClass($fieldName);
        $inverse = $classMetadata->isAssociationInverseSide($fieldName);
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        $reference = $this->getEntityManager()->getReference($targetClass, $id);

        if (!$inverse) {
            if ($collection) {
                /** @var Collection $collection */
                $collection = $propertyAccessor->getValue($entity, $fieldName);
                $collection->add($reference);
            } else {
                $propertyAccessor->setValue($entity, $fieldName, $reference);
            }
            $this->getEntityManager()->flush($entity);
        } else {
            $inverseClassMetadata = $this->getEntityManager()->getClassMetadata($targetClass);
            $association = $classMetadata->getAssociationMapping($fieldName);
            $inverseFieldName = $association['mappedBy'];
            $inverseCollection = $inverseClassMetadata->isCollectionValuedAssociation($inverseFieldName);
            if ($inverseCollection) {
                /** @var Collection $collection */
                $collection = $propertyAccessor->getValue($reference, $inverseFieldName);
                $collection->add($entity);
            } else {
                $propertyAccessor->setValue($reference, $inverseFieldName, $entity);
            }
            $this->getEntityManager()->flush($reference);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function removeAssociation($entity, string $fieldName, $id = null)
    {
        $classMetadata = $this->getEntityManager()->getClassMetadata(get_class($entity));
        $collection = $classMetadata->isCollectionValuedAssociation($fieldName);
        $targetClass = $classMetadata->getAssociationTargetClass($fieldName);
        $inverse = $classMetadata->isAssociationInverseSide($fieldName);
        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        if ($inverse) {
            $reference = $this->getEntityManager()->getReference($targetClass, $id);
            $inverseClassMetadata = $this->getEntityManager()->getClassMetadata($targetClass);
            $association = $classMetadata->getAssociationMapping($fieldName);
            $inverseFieldName = $association['mappedBy'];
            $inverseCollection = $inverseClassMetadata->isCollectionValuedAssociation($inverseFieldName);
            if ($inverseCollection) {
                /** @var Collection $collection */
                $collection = $propertyAccessor->getValue($reference, $inverseFieldName);
                $collection->removeElement($entity);
            } else {
                $propertyAccessor->setValue($reference, $inverseFieldName, null);
            }
            $this->getEntityManager()->flush($reference);
        } else {
            if ($collection) {
                $reference = $this->getEntityManager()->getReference($targetClass, $id);
                /** @var Collection $collection */
                $collection = $propertyAccessor->getValue($entity, $fieldName);
                $collection->removeElement($reference);
            } else {
                $propertyAccessor->setValue($entity, $fieldName, null);
            }
            $this->getEntityManager()->flush($entity);
        }
    }

    /**
     * @param string        $fieldName
     * @param ClassMetadata $classMetadata
     *
     * @return string
     */
    protected function getInverseFieldName(string $fieldName, ClassMetadata $classMetadata)
    {
        $association = $classMetadata->getAssociationMapping($fieldName);
        if ($classMetadata->isAssociationInverseSide($fieldName)) {
            return $association['mappedBy'];
        } else {
            return $association['inversedBy'];
        }
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger(): LoggerInterface
    {
        if (null === $this->logger) {
            $this->logger = new NullLogger();
        }

        return $this->logger;
    }
}
