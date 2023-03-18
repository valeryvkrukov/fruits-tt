<?php

namespace App\Entity;

use App\Repository\NutritionsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NutritionsRepository::class)]
class Nutritions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $carbohydrates = null;

    #[ORM\Column]
    private ?float $protein = null;

    #[ORM\Column]
    private ?float $fat = null;

    #[ORM\Column]
    private ?float $calories = null;

    #[ORM\Column]
    private ?float $sugar = null;

    #[ORM\OneToOne(mappedBy: 'nutritions', cascade: ['persist', 'remove'])]
    private ?Fruit $fruit = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCarbohydrates(): ?float
    {
        return $this->carbohydrates;
    }

    public function setCarbohydrates(float $carbohydrates): self
    {
        $this->carbohydrates = $carbohydrates;

        return $this;
    }

    public function getProtein(): ?float
    {
        return $this->protein;
    }

    public function setProtein(float $protein): self
    {
        $this->protein = $protein;

        return $this;
    }

    public function getFat(): ?float
    {
        return $this->fat;
    }

    public function setFat(float $fat): self
    {
        $this->fat = $fat;

        return $this;
    }

    public function getCalories(): ?float
    {
        return $this->calories;
    }

    public function setCalories(float $calories): self
    {
        $this->calories = $calories;

        return $this;
    }

    public function getSugar(): ?float
    {
        return $this->sugar;
    }

    public function setSugar(float $sugar): self
    {
        $this->sugar = $sugar;

        return $this;
    }

    public function getFruit(): ?Fruit
    {
        return $this->fruit;
    }

    public function setFruit(Fruit $fruit): self
    {
        // set the owning side of the relation if necessary
        if ($fruit->getNutritions() !== $this) {
            $fruit->setNutritions($this);
        }

        $this->fruit = $fruit;

        return $this;
    }
}
