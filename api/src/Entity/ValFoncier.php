<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ValFoncierRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ValFoncierRepository::class)]
#[ApiResource]
class ValFoncier
{
    const TYPES = ["Maison", "Appartement"];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateAquisition = null;

    #[ORM\Column(length: 255)]
    #[Assert\Choice(choices: ValFoncier::TYPES, message: "choose a valid type")]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $codePostal = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Range(min: 0)]
    private ?float $surface = null;

    #[ORM\Column]
    #[Assert\Range(min: 0)]
    private ?float $prix = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateAquisition(): ?\DateTimeInterface
    {
        return $this->dateAquisition;
    }

    public function setDateAquisition(?\DateTimeInterface $dateAquisition): self
    {
        $this->dateAquisition = $dateAquisition;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getSurface(): ?float
    {
        return $this->surface;
    }

    public function setSurface(?float $surface): self
    {
        $this->surface = $surface;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }
}
