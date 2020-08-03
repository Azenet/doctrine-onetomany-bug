<?php

namespace App\Repository;

use App\Entity\Baz;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Baz|null find($id, $lockMode = null, $lockVersion = null)
 * @method Baz|null findOneBy(array $criteria, array $orderBy = null)
 * @method Baz[]    findAll()
 * @method Baz[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BazRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Baz::class);
    }

    // /**
    //  * @return Baz[] Returns an array of Baz objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Baz
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
