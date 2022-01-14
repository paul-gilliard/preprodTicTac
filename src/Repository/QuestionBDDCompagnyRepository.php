<?php

namespace App\Repository;

use App\Entity\QuestionBDDCompagny;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method QuestionBDDCompagny|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuestionBDDCompagny|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuestionBDDCompagny[]    findAll()
 * @method QuestionBDDCompagny[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionBDDCompagnyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuestionBDDCompagny::class);
    }

    // /**
    //  * @return QuestionBDDCompagny[] Returns an array of QuestionBDDCompagny objects
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
    public function findOneBySomeField($value): ?QuestionBDDCompagny
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
