<?php

namespace Dontdrinkandroot\Service;

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

        return new Paginator($queryBuilder);
    }

    /**
     * {@inheritdoc}
     */
    public function createAssociation($entity, string $fieldName, $child)
    {
        $classMetadata = $this->getEntityManager()->getClassMetadata(get_class($entity));

        $inverseFieldName = $this->getInverseFieldName($fieldName, $classMetadata);
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        $propertyAccessor->setValue($child, $inverseFieldName, $entity);

        $this->getEntityManager()->persist($child);
        $this->getEntityManager()->flush($child);

        return $child;
    }

    /**
     * {@inheritdoc}
     */
    public function addAssociation($entity, string $fieldName, $id)
    {
        $classMetadata = $this->getEntityManager()->getClassMetadata(get_class($entity));
        $collection = $classMetadata->isCollectionValuedAssociation($fieldName);
        $targetClass = $classMetadata->getAssociationTargetClass($fieldName);

        if ($collection) {
            $inverseFieldName = $this->getInverseFieldName($fieldName, $classMetadata);

            $reference = $this->getEntityManager()->getReference($targetClass, $id);
            $propertyAccessor = PropertyAccess::createPropertyAccessor();
            $propertyAccessor->setValue($reference, $inverseFieldName, $entity);

            $this->getEntityManager()->flush($reference);
        } else {
            $reference = $this->getEntityManager()->getReference($targetClass, $id);
            $propertyAccessor = PropertyAccess::createPropertyAccessor();
            $propertyAccessor->setValue($entity, $fieldName, $reference);

            $this->getEntityManager()->flush($entity);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function removeAssociation($entity, string $fieldName, $id)
    {
        $classMetadata = $this->getEntityManager()->getClassMetadata(get_class($entity));
        $collection = $classMetadata->isCollectionValuedAssociation($fieldName);
        $targetClass = $classMetadata->getAssociationTargetClass($fieldName);

        if ($collection) {
            $inverseFieldName = $this->getInverseFieldName($fieldName, $classMetadata);

            $reference = $this->getEntityManager()->getReference($targetClass, $id);
            $propertyAccessor = PropertyAccess::createPropertyAccessor();
            $propertyAccessor->setValue($reference, $inverseFieldName, null);

            $this->getEntityManager()->flush($reference);
        } else {
            $propertyAccessor = PropertyAccess::createPropertyAccessor();
            $propertyAccessor->setValue($entity, $fieldName, null);

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
