<?php
/*
 * This file is part of the Desksheet project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Desksheet\System\Repository\ORM;

use Desksheet\System\Model\ResourceInterface;
use Desksheet\System\Repository\ResourceRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

class ResourceRepository implements ResourceRepositoryInterface
{
    protected EntityManagerInterface $entityManager;

    protected string $className;

    public function __construct(string $className, EntityManagerInterface $entityManager)
    {
        $this->className = $className;
        $this->entityManager = $entityManager;
    }

    public function add(ResourceInterface $resource): void
    {
        $this->entityManager->persist($resource);
    }

    public function remove(ResourceInterface $resource): void
    {
        $this->entityManager->remove($resource);
    }

    public function findById($resourceId): ?object
    {
        return (null !== $resourceId) ? $this->entityManager->find($this->className, $resourceId) : null;
    }

    public function count(): int
    {
        return (int) $this->createQueryBuilder('o')
            ->select('COUNT(o.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function createQueryBuilder(string $alias, ?string $indexBy = null): QueryBuilder
    {
        return $this->entityManager->createQueryBuilder()
            ->select($alias)
            ->from($this->className, $alias, $indexBy);
    }

    public function findOneBy(array $criteria): ?object
    {
        return $this->entityManager
            ->getUnitOfWork()
            ->getEntityPersister($this->className)
            ->load($criteria, null, null, array(), 0, 1);
    }
}
