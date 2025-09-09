<?php

namespace App\Entity;

use App\Repository\SocioRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SocioRepository::class)]
class Socio
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $estado = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $observacion = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $fecha_ingreso = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $fecha_egreso = null;

    #[ORM\ManyToOne(inversedBy: 'socios')]
    private ?User $user = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $fecha_update = null;

    public function __toString(): string
    {
        return strval($this->getId());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isEstado(): ?bool
    {
        return $this->estado;
    }

    public function setEstado(bool $estado): static
    {
        $this->estado = $estado;

        return $this;
    }

    public function getObservacion(): ?string
    {
        return $this->observacion;
    }

    public function setObservacion(?string $observacion): static
    {
        $this->observacion = $observacion;

        return $this;
    }

    public function getFechaIngreso(): ?\DateTime
    {
        return $this->fecha_ingreso;
    }

    public function setFechaIngreso(?\DateTime $fecha_ingreso): static
    {
        $this->fecha_ingreso = $fecha_ingreso;

        return $this;
    }

    public function getFechaEgreso(): ?\DateTime
    {
        return $this->fecha_egreso;
    }

    public function setFechaEgreso(?\DateTime $fecha_egreso): static
    {
        $this->fecha_egreso = $fecha_egreso;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getFechaUpdate(): ?\DateTime
    {
        return $this->fecha_update;
    }

    public function setFechaUpdate(?\DateTime $fecha_update): static
    {
        $this->fecha_update = $fecha_update;

        return $this;
    }
}
