<?php

namespace App\Repository;

use App\Entity\Valoraciones;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Valoraciones>
 *
 * @method Valoraciones|null find($id, $lockMode = null, $lockVersion = null)
 * @method Valoraciones|null findOneBy(array $criteria, array $orderBy = null)
 * @method Valoraciones[]    findAll()
 * @method Valoraciones[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ValoracionesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Valoraciones::class);
    }

//    /**
//     * @return Valoraciones[] Returns an array of Valoraciones objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Valoraciones
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
