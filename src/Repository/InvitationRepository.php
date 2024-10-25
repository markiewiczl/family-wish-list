<?php

namespace App\Repository;

use App\Entity\Invitation;
use App\Entity\InvitationInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Invitation>
 */
class InvitationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Invitation::class);
    }

    public function create(): InvitationInterface
    {
        return new Invitation();
    }

    public function save(InvitationInterface $invitation, bool $flush = false): void
    {
        $this->getEntityManager()->persist($invitation);

        if ($flush === true) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(InvitationInterface $family, bool $flush = false): void
    {
        $this->getEntityManager()->remove($family);

        if ($flush === true) {
            $this->getEntityManager()->flush();
        }
    }

    //    /**
    //     * @return Invitation[] Returns an array of Invitation objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('i.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Invitation
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
