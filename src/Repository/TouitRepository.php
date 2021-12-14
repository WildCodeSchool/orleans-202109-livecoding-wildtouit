<?php

namespace App\Repository;

use App\Entity\Touit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Touit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Touit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Touit[]    findAll()
 * @method Touit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TouitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Touit::class);
    }

    // /**
    //  * @return Touit[] Returns an array of Touit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Touit
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
