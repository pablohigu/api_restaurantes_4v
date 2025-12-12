<?php

namespace App\Controller;

use App\Entity\RestaurantType;
use App\Model\RetauranteTypeDTO;
use App\Model\RestauranteTypeDTO;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\RestauranteType as RestauranteTypeEntity; // Alias para diferenciar
use App\Model\RestauranteType as RestauranteTypeModel;   // Tu modelo en App/Model

final class TypesRestaurantController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    #[Route('/types/restaurant', name: 'app_types_restaurant')]
    public function index(): JsonResponse
    {
        // 1. Buscamos en la ENTIDAD (La que está conectada a la BD)
        // Asegúrate de poner aquí el nombre correcto de tu entidad de Doctrine
        $typesBBDD = $this->entityManager->getRepository(RestaurantType::class)->findAll();
        $typesDTO = [];
        // 2. Iteramos sobre las entidades recuperadas
        foreach ($typesBBDD as $typeEntidad) {
          
            $typesDTO[] = new RestauranteTypeDTO(
                $typeEntidad->getId(),
                $typeEntidad->getTypeName() 
            );
        }

        return $this->json($typesDTO);
    }
}