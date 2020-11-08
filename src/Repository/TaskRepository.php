<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class TaskRepository
 * @package App\Repository
 */
class TaskRepository extends ServiceEntityRepository
{
    /**
     * TaskRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    /**
     * @var string
     */
    private $alias = 'task';

    /**
     * @param string $userId
     * @return array
     */
    public function findByUserId(string $userId): array
    {
        return $this
            ->createQueryBuilder($this->alias)
            ->where("{$this->alias}.user = :userId")
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getArrayResult();
    }

    /**
     * @param string $userId
     * @param string|null $fromDate
     * @param string|null $toDate
     * @return int|mixed|string
     */
    public function findByUserIdAndDates(string $userId, ?string $fromDate, ?string $toDate)
    {
        $query = $this->createQueryBuilder($this->alias)
            ->where("{$this->alias}.user = :userId")
            ->setParameter('userId', $userId);

        if (!empty($fromDate)) {
            $query->andWhere("{$this->alias}.createdAt >= :from")
                ->setParameter('from', $fromDate);
        }
        if (!empty($toDate)) {
            $query->andWhere("{$this->alias}.createdAt < :to")
                ->setParameter('to', $toDate);
        }

        return $query
            ->orderBy("{$this->alias}.createdAt", 'DESC')
            ->getQuery()
            ->getResult();
    }
}
