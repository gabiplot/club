<?php

namespace App\Entity;

use App\Repository\AsignarCuotaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AsignarCuotaRepository::class)]
class AsignarCuota
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]    
    #[Assert\NotNull]
    private ?\DateTime $fecha = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private ?string $periodo = null;

    public function __toString(): string
    {
        $periodo = "";

        $periodo = $this->getPeriodo() ?? "";

        return strval($periodo);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFecha(): ?\DateTime
    {
        return $this->fecha;
    }

    public function setFecha(?\DateTime $fecha): static
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getPeriodo(): ?string
    {
        return $this->periodo;
    }

    public function setPeriodo(?string $periodo): static
    {
        $this->periodo = $periodo;

        return $this;
    }
}
