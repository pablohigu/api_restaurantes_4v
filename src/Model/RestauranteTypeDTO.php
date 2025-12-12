<?php
namespace App\Model;
class RestauranteTypeDTO
{
    public function __construct(
    public int $id,
    public string $typeName){}
     public function getId(): int
    {
        return $this->id;
    }

    public function getTypeName(): string
    {
        return $this->typeName;
    }
}
?>