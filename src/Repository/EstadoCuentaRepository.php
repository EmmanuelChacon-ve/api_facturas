<?php

namespace App\Repository;

use App\Entity\EstadoCuenta;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EstadoCuenta>
 *
 * @method EstadoCuenta|null find($id, $lockMode = null, $lockVersion = null)
 * @method EstadoCuenta|null findOneBy(array $criteria, array $orderBy = null)
 * @method EstadoCuenta[]    findAll()
 * @method EstadoCuenta[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EstadoCuentaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EstadoCuenta::class);
    }

//    /**
//     * @return EstadoCuenta[] Returns an array of EstadoCuenta objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?EstadoCuenta
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
