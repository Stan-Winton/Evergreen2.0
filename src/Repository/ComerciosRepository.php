<?php

namespace App\Repository;

use App\Entity\Comercios;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Comercios>
 *
 * @method Comercios|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comercios|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comercios[]    findAll()
 * @method Comercios[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComerciosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comercios::class);
    }

    public function findWithProductsByComercio($comercioId)
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.productos', 'p')
            ->addSelect('p')
            ->where('c.id = :id')
            ->andWhere('p.comercios = :comercioId')
            ->setParameter('id', $comercioId)
            ->setParameter('comercioId', $comercioId)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findByCodigoPostal($codigoPostal): array
{
    return $this->createQueryBuilder('c')
        ->andWhere('c.codigoPostal = :val')
        ->setParameter('val', $codigoPostal)
        ->getQuery()
        ->getResult();
}

    // Uncomment these methods if you need them

    // /**
    //  * @return Comercios[] Returns an array of Comercios objects
    //  */
    // public function findByExampleField($value): array
    // {
    //     return $this->createQueryBuilder('c')
    //         ->andWhere('c.exampleField = :val')
    //         ->setParameter('val', $value)
    //         ->orderBy('c.id', 'ASC')
    //         ->setMaxResults(10)
    //         ->getQuery()
    //         ->getResult();
    // }

    // public function findOneBySomeField($value): ?Comercios
    // {
    //     return $this->createQueryBuilder('c')
    //         ->andWhere('c.exampleField = :val')
    //         ->setParameter('val', $value)
    //         ->getQuery()
    //         ->getOneOrNullResult();
    // }
}