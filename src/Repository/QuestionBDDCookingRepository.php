<?php

namespace App\Repository;

use App\Entity\QuestionBDDCooking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method QuestionBDDCooking|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuestionBDDCooking|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuestionBDDCooking[]    findAll()
 * @method QuestionBDDCooking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionBDDCookingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuestionBDDCooking::class);
    }

    // /**
    //  * @return QuestionBDDCooking[] Returns an array of QuestionBDDCooking objects
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
    public function findOneBySomeField($value): ?QuestionBDDCooking
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function countByQuestion() {
 
        return $this->createQueryBuilder('l')
                        ->select('COUNT(l)')
                        ->getQuery()
                        ->getSingleScalarResult();
 
    }
}
