<?php

namespace App\Repository\User;

use App\Entity\User\User;
use App\Model\User\UserFilter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getUsersByFilter(UserFilter $filter): array
    {
        $qb = $this->createQueryBuilder('u')
            ->setFirstResult($filter->getPage())
            ->setMaxResults($filter->getLimit());

        if ($filter->getSortByNick()) {
            $qb->orderBy('u.nick', $filter->getSortDirection());
        } else {
            $qb->orderBy('u.id', $filter->getSortDirection());
        }

        return $qb->getQuery()->getResult();
    }
}
