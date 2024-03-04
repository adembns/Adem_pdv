<?php

namespace App\Repository;

use App\Entity\Article1;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article1>
 *
 * @method Article1|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article1|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article1[]    findAll()
 * @method Article1[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class Article1Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article1::class);
    }

public function orderbydesc_contenu()
{
    return $this->createQueryBuilder('a')
    ->orderBy('a.contenu','Desc')
    ->getQuery()
    ->getResult();
}

public function orderbyasc_contenu()
{
    return $this->createQueryBuilder('a')
    ->orderBy('a.contenu','Asc')
    ->getQuery()
    ->getResult();
}

//    /**
//     * @return Article1[] Returns an array of Article1 objects
//     */
    public function paginationQuery()
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.id', 'ASC')
            ->getQuery()
        ;
    }

//    public function findOneBySomeField($value): ?Article1
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

}
