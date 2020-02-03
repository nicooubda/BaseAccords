<?php

namespace App\Repository;

use App\Entity\Repertoire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Repertoire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Repertoire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Repertoire[]    findAll()
 * @method Repertoire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RepertoireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Repertoire::class);
    }

    // /**
    //  * @return Repertoire[] Returns an array of Repertoire objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Repertoire
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findT($titre, $type, $langue, $lieu, $motCle, $date, $resume)
    {
        $emConfig = $this->getEntityManager()->getConfiguration();
        $emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');

        return $this->createQueryBuilder('r')
            ->join('r.accord', 'a')
            ->join('r.langue', 'l')
            ->join('a.sousTypeDocument', 's')
            ->where('a.intitule like :titre')
            ->andwhere('a.lieuSignature like :lieu')
            ->andwhere('l.langue like :langue')
            ->andwhere('a.motCle like :motCle')
            ->andwhere('a.resume like :resume')
            ->andwhere('YEAR(a.dateSignature_at) =:date')
            ->andwhere('s.sousType like :type')
            ->setParameter('titre', '%'.$titre.'%')
            ->setParameter('resume', '%'.$resume.'%')
            ->setParameter('lieu', '%'.$lieu.'%')
            ->setParameter('langue', '%'.$langue.'%')
            ->setParameter('date', $date)
            ->setParameter('motCle', '%'.$motCle.'%')
            ->setParameter('type', '%'.$type.'%')
            ->getQuery()
            ->getResult()
        ;
    }
}
