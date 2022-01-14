<?php

namespace App\Repository;

use App\Entity\QuestionValideeCompagny;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method QuestionValideeCompagny|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuestionValideeCompagny|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuestionValideeCompagny[]    findAll()
 * @method QuestionValideeCompagny[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionValideeCompagnyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuestionValideeCompagny::class);
    }

    // /**
    //  * @return QuestionValideeCompagny[] Returns an array of QuestionValideeCompagny objects
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
    public function findOneBySomeField($value): ?QuestionValideeCompagny
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
