<?php

namespace App\Repository;

use App\Entity\JavaArticle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method JavaArticle|null find($id, $lockMode = null, $lockVersion = null)
 * @method JavaArticle|null findOneBy(array $criteria, array $orderBy = null)
 * @method JavaArticle[]    findAll()
 * @method JavaArticle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JavaArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JavaArticle::class);
    }

    // /**
    //  * @return JavaArticle[] Returns an array of JavaArticle objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('j.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?JavaArticle
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
