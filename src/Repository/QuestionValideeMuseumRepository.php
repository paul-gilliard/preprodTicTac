<?php

namespace App\Repository;

use App\Entity\QuestionValideeMuseum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method QuestionValideeMuseum|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuestionValideeMuseum|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuestionValideeMuseum[]    findAll()
 * @method QuestionValideeMuseum[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionValideeMuseumRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuestionValideeMuseum::class);
    }

    // /**
    //  * @return QuestionValideeMuseum[] Returns an array of QuestionValideeMuseum objects
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
    public function findOneBySomeField($value): ?QuestionValideeMuseum
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
