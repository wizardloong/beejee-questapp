<?php
declare(strict_types=1);

namespace App\ReadModel;

use App\Entity\Quest;
use Doctrine\ORM\EntityRepository;

class QuestReadRepository
{
    private $repository;

    public function __construct(EntityRepository $repository)
    {
        $this->repository = $repository;
    }

    public function countAll(): int
    {
        return $this->repository
            ->createQueryBuilder('q')
            ->select('COUNT(q)')
            ->getQuery()
            ->getSingleScalarResult() * 1;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $sort
     * @param string $order
     * @return Quest[]
     */
    public function all(
        int $offset,
        int $limit,
        string $sort = 'id',
        string $order = 'DESC'
    ): array {
        if ($sort == 'status') {
            $sort = 'completed';
        }
        return $this->repository
            ->createQueryBuilder('q')
            ->select('q')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->orderBy('q.' . $sort, $order)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param int $id
     * @return Quest|object|null
     */
    public function find(int $id): ?Quest
    {
        return $this->repository->find($id);
    }
}
