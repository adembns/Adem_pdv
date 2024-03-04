<?php

namespace App\Repository;

use App\Entity\Comment1;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Comment1>
 *
 * @method Comment1|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment1|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment1[]    findAll()
 * @method Comment1[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class Comment1Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment1::class);
    }

    public function orderbydesc_date()
{
    return $this->createQueryBuilder('c')
    ->orderBy('c.created','Desc')
    ->getQuery()
    ->getResult();
}



//    /**
//     * @return Comment1[] Returns an array of Comment1 objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Comment1
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
