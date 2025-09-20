<?php

namespace App\Entity;

use App\Repository\PagoCuotaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PagoCuotaRepository::class)]
class PagoCuota
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'pagoCuotas')]
    private ?Socio $socio = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $fecha_pago = null;

    public function __toString(): string
    {

        $socio = $this->getSocio() ?? "";

        return strval($socio);
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSocio(): ?Socio
    {
        return $this->socio;
    }

    public function setSocio(?Socio $socio): static
    {
        $this->socio = $socio;

        return $this;
    }

    public function getFechaPago(): ?\DateTime
    {
        return $this->fecha_pago;
    }

    public function setFechaPago(?\DateTime $fecha_pago): static
    {
        $this->fecha_pago = $fecha_pago;

        return $this;
    }
}
