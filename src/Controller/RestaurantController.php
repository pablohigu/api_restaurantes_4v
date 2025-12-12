<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Model\RestauranteDTO;
use App\Model\RestauranteTypeDTO;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Model\RestauranteType; // <--- NECESARIO: Descomenta o añade esto

final class RestaurantController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager) 
    {
    }

    #[Route('/restaurants', name: 'app_restaurants', methods: ['GET'])]
    public function getRestaurantes(): JsonResponse 
    {
        $restaurantesBBDD = $this->entityManager->getRepository(Restaurant::class)->findAllWithTypes();

        $restaurantesDTO = [];

        foreach ($restaurantesBBDD as $restauranteEntidad) {
            $tipoDto = null;
            if ($restauranteEntidad->getType() !== null) {
                $tipoDto = new RestauranteTypeDTO(
                    $restauranteEntidad->getType()->getId(),
                    $restauranteEntidad->getType()->getTypeName() 
                );
            }
            $restaurantesDTO[] = new RestauranteDTO(
                $restauranteEntidad->getId(),
                $restauranteEntidad->getName(),
                $tipoDto 
            );
        }

        return $this->json($restaurantesDTO);
    }

    // ... (Tu método POST se queda igual, o puedes actualizar la respuesta también) ...
    #[Route('/restaurants', name: 'post_restaurants', methods:['POST'], format: 'json')]
    public function newRestaurants(#[MapRequestPayload] RestauranteDTO $restauranteDto): JsonResponse
    {
       $newRestaurantEntity = new Restaurant();
       $newRestaurantEntity->setName($restauranteDto->getName());
       
       // NOTA: Si quieres guardar el tipo al crear, necesitarás lógica extra aquí para buscar el tipo por ID.
       
       $this->entityManager->persist($newRestaurantEntity);
       $this->entityManager->flush();

       $restauranteResponse = new RestauranteDTO(
           $newRestaurantEntity->getId(),
           $newRestaurantEntity->getName(),
           null // De momento null en el POST si no lo has implementado
        );

       return $this->json($restauranteResponse, 201);
    }
}