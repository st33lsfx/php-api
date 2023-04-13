<?php

namespace App\Repository\Followers;

use App\Entity\Followers\Followers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Followers>
 *
 * @method Followers|null find($id, $lockMode = null, $lockVersion = null)
 * @method Followers|null findOneBy(array $criteria, array $orderBy = null)
 * @method Followers[]    findAll()
 * @method Followers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FollowersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Followers::class);
    }

    public function save(Followers $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Followers $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
