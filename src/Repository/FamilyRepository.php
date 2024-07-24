<?php

namespace App\Repository;

use App\Entity\Family;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Family>
 */
class FamilyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Family::class);
    }

    public function create(): Family
    {
        return new Family();
    }

    public function save(Family $family, bool $flush = false): void
    {
        $this->getEntityManager()->persist($family);

        if ($flush === true) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Family $family, bool $flush = false): void
    {
        $this->getEntityManager()->remove($family);

        if ($flush === true) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Family[] Returns an array of Family objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

    //    public function findOneBySomeField($value): ?Family
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
