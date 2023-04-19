<?php

namespace App\Entity;

use App\Repository\FruitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FruitRepository::class)]
class Fruit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $genus = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $family = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fruitOrder = null;

    #[ORM\Column(nullable: true)]
    private ?array $nutritions = null;

    #[ORM\Column(nullable: true)]
    private ?float $nutrition_sum = null;


    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGenus(): ?string
    {
        return $this->genus;
    }

    public function setGenus(?string $genus): self
    {
        $this->genus = $genus;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFamily(): ?string
    {
        return $this->family;
    }

    public function setFamily(?string $family): self
    {
        $this->family = $family;

        return $this;
    }

    public function getFruitOrder(): ?string
    {
        return $this->fruitOrder;
    }

    public function setFruitOrder(?string $fruitOrder): self
    {
        $this->fruitOrder = $fruitOrder;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getNutritions(): ?array
    {
        return $this->nutritions;
    }

    /**
     * @param array|null $nutritions
     */
    public function setNutritions(?array $nutritions): void
    {
        $this->nutritions = $nutritions;
    }

    /**
     * @return float|null
     */
    public function getNutritionSum(): ?float
    {
        return $this->nutrition_sum;
    }

    /**
     * @param float|null $nutrition_sum
     */
    public function setNutritionSum(?float $nutrition_sum): void
    {
        $this->nutrition_sum = $nutrition_sum;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'genus' => $this->getGenus(),
            'family' => $this->getFamily(),
            'order' => $this->getFruitOrder(),
            'nutritions' => $this->getNutritions(),
            'nutritionSum' => $this->getNutritionSum()
        ];
    }

}
