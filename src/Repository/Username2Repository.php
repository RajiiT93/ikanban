<?php

namespace App\Repository;

use App\Entity\Username2;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Username2>
 *
 * @method Username2|null find($id, $lockMode = null, $lockVersion = null)
 * @method Username2|null findOneBy(array $criteria, array $orderBy = null)
 * @method Username2[]    findAll()
 * @method Username2[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class Username2Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Username2::class);
    }

//    /**
//     * @return Username2[] Returns an array of Username2 objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Username2
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
