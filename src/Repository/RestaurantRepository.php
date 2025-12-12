<?php

namespace App\Repository;

use App\Entity\Restaurant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Restaurant>
 */
class RestaurantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Restaurant::class);
    }

    /**
     * Obtiene los restaurantes y sus tipos en una sola consulta (Optimización JOIN).
     * Evita hacer una consulta extra por cada restaurante (Problema N+1).
     */
    public function findAllWithTypes(): array
    {
        return $this->createQueryBuilder('r') // 'r' es el alias para la tabla Restaurant
            ->leftJoin('r.type', 't')         // Hacemos el JOIN con la relación 'type' y le damos el alias 't'
            ->addSelect('t')                  // IMPORTANTE: Seleccionamos los datos de 't' para que Doctrine los traiga ya
            ->getQuery()
            ->getResult();
    }
}