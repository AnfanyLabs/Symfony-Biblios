<?php

namespace App\Repository;

use App\Entity\Author;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Author>
 */
class AuthorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

    public function findByDateOfBirth(array $dates= []): array {
        $qb = $this->createQueryBuilder('a');

        if(array_key_exists('neLe', $dates)){
            $qb->andWhere('a.dateOfBirth >= :neLe')
               ->setParameter('neLe', new \DateTimeImmutable($dates['neLe']));
        }
        if (array_key_exists('mortLe', $dates)) {
            $qb->andWhere("a.dateOfDeath <= :mortLe")
               ->setParameter('mortLe', new DateTimeImmutable($dates['mortLe']));
        }
        return $qb->orderBy("a.dateOfBirth", 'DESC')
                  ->getQuery()
                  ->getResult();
    }

    //    /**
    //     * @return Author[] Returns an array of Author objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Author
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
