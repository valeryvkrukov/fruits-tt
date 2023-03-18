<?php

namespace App\Entity;

use App\Repository\FruitRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FruitRepository::class)]
class Fruit
{
    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER, name: '`id`', unique: true)]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[ORM\Column(type: Types::STRING, name: '`genus`', length: 255)]
    private ?string $genus = null;

    #[Assert\NotBlank]
    #[ORM\Column(type: Types::STRING, name: '`name`', length: 255)]
    private ?string $name = null;

    #[Assert\NotBlank]
    #[ORM\Column(type: Types::STRING, name: '`family`', length: 255)]
    private ?string $family = null;

    #[Assert\NotBlank]
    #[ORM\Column(type: Types::STRING, name: '`order`', length: 255)]
    private ?string $order = null;

    #[ORM\OneToOne(inversedBy: 'fruit', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Nutritions $nutritions = null;

    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getGenus(): ?string
    {
        return $this->genus;
    }

    public function setGenus(string $genus): self
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

    public function setFamily(string $family): self
    {
        $this->family = $family;

        return $this;
    }

    public function getOrder(): ?string
    {
        return $this->order;
    }

    public function setOrder(string $order): self
    {
        $this->order = $order;

        return $this;
    }

    public function getNutritions(): ?Nutritions
    {
        return $this->nutritions;
    }

    public function setNutritions(Nutritions $nutritions): self
    {
        $this->nutritions = $nutritions;

        return $this;
    }
}
