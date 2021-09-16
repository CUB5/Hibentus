<?php

namespace App\Repository;

use App\Entity\Evento;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @method Evento|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evento|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evento[]    findAll()
 * @method Evento[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evento::class);
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
    //  * @return Evento[] Returns an array of Evento objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Evento
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
