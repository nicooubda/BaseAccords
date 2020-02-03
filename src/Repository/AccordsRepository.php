<?php

namespace App\Repository;

use App\Entity\Accords;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Accords|null find($id, $lockMode = null, $lockVersion = null)
 * @method Accords|null findOneBy(array $criteria, array $orderBy = null)
 * @method Accords[]    findAll()
 * @method Accords[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccordsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Accords::class);
    }

    // /**
    //  * @return Accords[] Returns an array of Accords objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Accords
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
