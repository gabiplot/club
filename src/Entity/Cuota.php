<?php

namespace App\Entity;

use App\Repository\CuotaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CuotaRepository::class)]
class Cuota
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $importe = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $importe_abonado = null;

    #[ORM\Column(length: 255)]
    private ?string $estado = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $saldo = null;

    #[ORM\ManyToOne(inversedBy: 'cuotas')]
    private ?User $user = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $fecha_update = null;

    #[ORM\ManyToOne(inversedBy: 'cuotas')]
    private ?Socio $socio = null;

    #[ORM\ManyToOne(inversedBy: 'cuotas')]
    private ?AsignarCuota $asignarcuota = null;

    /**
     * @var Collection<int, PagoCuotaDetalle>
     */
    #[ORM\OneToMany(targetEntity: PagoCuotaDetalle::class, mappedBy: 'cuota')]
    private Collection $pagoCuotaDetalles;

    public function __construct()
    {
        $this->pagoCuotaCuotas = new ArrayCollection();
        $this->pagoCuotaDetalles = new ArrayCollection();
    }

    public function __toString(): string
    {

        $asignarcuota = $this->getAsignarcuota() ?? "";
        $socio = $this->getSocio() ?? "";
        $saldo = $this->getSaldo() ?? "";

        return strval($asignarcuota . " " . $socio . " Saldo: " . $saldo);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImporte(): ?string
    {
        return $this->importe;
    }

    public function setImporte(string $importe): static
    {
        $this->importe = $importe;

        return $this;
    }

    public function getImporteAbonado(): ?string
    {
        return $this->importe_abonado;
    }

    public function setImporteAbonado(string $importe_abonado): static
    {
        $this->importe_abonado = $importe_abonado;

        return $this;
    }

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): static
    {
        $this->estado = $estado;

        return $this;
    }

    public function getSaldo(): ?string
    {
        return $this->saldo;
    }

    public function setSaldo(string $saldo): static
    {
        $this->saldo = $saldo;

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

    public function getSocio(): ?Socio
    {
        return $this->socio;
    }

    public function setSocio(?Socio $socio): static
    {
        $this->socio = $socio;

        return $this;
    }

    public function getAsignarcuota(): ?AsignarCuota
    {
        return $this->asignarcuota;
    }

    public function setAsignarcuota(?AsignarCuota $asignarcuota): static
    {
        $this->asignarcuota = $asignarcuota;

        return $this;
    }

    /**
     * @return Collection<int, PagoCuotaDetalle>
     */
    public function getPagoCuotaDetalles(): Collection
    {
        return $this->pagoCuotaDetalles;
    }

    public function addPagoCuotaDetalle(PagoCuotaDetalle $pagoCuotaDetalle): static
    {
        if (!$this->pagoCuotaDetalles->contains($pagoCuotaDetalle)) {
            $this->pagoCuotaDetalles->add($pagoCuotaDetalle);
            $pagoCuotaDetalle->setCuota($this);
        }

        return $this;
    }

    public function removePagoCuotaDetalle(PagoCuotaDetalle $pagoCuotaDetalle): static
    {
        if ($this->pagoCuotaDetalles->removeElement($pagoCuotaDetalle)) {
            // set the owning side to null (unless already changed)
            if ($pagoCuotaDetalle->getCuota() === $this) {
                $pagoCuotaDetalle->setCuota(null);
            }
        }

        return $this;
    }
}
