<?php

namespace App\Model;

// 1. ELIMINA la línea: use App\Entity\RestaurantType;
// Como RestauranteTypeDTO está en el mismo namespace (App\Model), no hace falta importarlo,
// pero si quieres ser explícito puedes poner: use App\Model\RestauranteTypeDTO;

class RestauranteDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public ?RestauranteTypeDTO $resType
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
    public function getResType(): ?RestauranteTypeDTO
    {
        return $this->resType;
    }
}