<?php

namespace App\Repository;

use App\Entity\Categoria;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Categoria|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categoria|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categoria[]    findAll()
 * @method Categoria[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoriaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categoria::class);
    }

    public function paginate($sql, $page = 1, $limit = 10){
        $paginador = new Paginator($sql);

        $paginador->getQuery()
                ->setFirstResult($limit * ($page - 1))
                ->setMaxResults($limit);

        return $paginador;
    }

    public function findAllPaginado($page=1, $limit = 10){
        $qb = $this->createQueryBuilder('c');

        $query = $qb->getQuery();

        $paginador = $this->paginate($query, $page, $limit);
        $nMaxPages = ceil($paginador->count()/$limit);

        return [
            "paginador" => $paginador,
            "nMaxPages" => $nMaxPages,
            "res" => $query->getResult()
        ];

    }

    // /**
    //  * @return Categoria[] Returns an array of Categoria objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Categoria
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
