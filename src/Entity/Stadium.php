<?php

namespace App\Entity;

use App\Repository\StadiumRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StadiumRepository::class)]
class Stadium
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $openingTime = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $closingTime = null;

    #[ORM\Column]
    private ?float $pricePerHour = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column]
    private ?int $zipCode = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column]
    private ?bool $hasShower = null;

    #[ORM\Column]
    private ?bool $hasPark = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getOpeningTime(): ?\DateTimeInterface
    {
        return $this->openingTime;
    }

    public function setOpeningTime(\DateTimeInterface $openingTime): static
    {
        $this->openingTime = $openingTime;

        return $this;
    }

    public function getClosingTime(): ?\DateTimeInterface
    {
        return $this->closingTime;
    }

    public function setClosingTime(\DateTimeInterface $closingTime): static
    {
        $this->closingTime = $closingTime;

        return $this;
    }

    public function getPricePerHour(): ?float
    {
        return $this->pricePerHour;
    }

    public function setPricePerHour(float $pricePerHour): static
    {
        $this->pricePerHour = $pricePerHour;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getZipCode(): ?int
    {
        return $this->zipCode;
    }

    public function setZipCode(int $zipCode): static
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function hasShower(): ?bool
    {
        return $this->hasShower;
    }

    public function setHasShower(bool $hasShower): static
    {
        $this->hasShower = $hasShower;

        return $this;
    }

    public function hasPark(): ?bool
    {
        return $this->hasPark;
    }

    public function setHasPark(bool $hasPark): static
    {
        $this->hasPark = $hasPark;

        return $this;
    }
}
