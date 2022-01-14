<?php

namespace App\Repository;

use App\Entity\QuestionValideeCooking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method QuestionValideeCooking|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuestionValideeCooking|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuestionValideeCooking[]    findAll()
 * @method QuestionValideeCooking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionValideeCookingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuestionValideeCooking::class);
    }


    // /**
    //  * @return QuestionValideeCooking[] Returns an array of QuestionValideeCooking objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?QuestionValideeCooking
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
