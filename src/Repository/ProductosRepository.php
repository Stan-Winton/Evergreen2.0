<?php

namespace App\Repository;

use App\Entity\Productos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Productos>
 *
 * @method Productos|null find($id, $lockMode = null, $lockVersion = null)
 * @method Productos|null findOneBy(array $criteria, array $orderBy = null)
 * @method Productos[]    findAll()
 * @method Productos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Productos::class);
    }

    /**
     * @return Productos[] Returns an array of Productos objects
     */
    public function findByNombre($value): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('LOWER(p.nombre) LIKE LOWER(:val)')
            ->andWhere('p.stock > 0') // Añadido esta línea
            ->setParameter('val', '%' . $value . '%')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Productos[] Returns an array of Productos objects
     */
    public function findByTipoProducto($value): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.tipo_producto = :val')
            ->andWhere('p.stock > 0') // Añadido esta línea
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult();
    }

    /**
    * @return string[] Returns an array of distinct tiposProducto
    */
    public function findDistinctTiposProducto(): array
    {
        $result = $this->createQueryBuilder('p')
            ->select('DISTINCT p.tipo_producto')
            ->getQuery()
            ->getScalarResult();

        // Flatten the array
        return array_column($result, 'tipo_producto');
    }
}