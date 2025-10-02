<?php

namespace App\Entity;

use App\Repository\PagoCuotaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @var Collection<int, PagoCuotaDetalle>
     */
    #[ORM\OneToMany(targetEntity: PagoCuotaDetalle::class, mappedBy: 'pagocuota')]
    private Collection $pagoCuotaDetalles;

    #[ORM\Column]
    private ?bool $estado = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $total = null;

    public function __construct()
    {
        $this->pagoCuotaDetalles = new ArrayCollection();
    }

    public function __toString(): string
    {

        $socio = $this->getSocio() ?? "";

        return strval($socio);
    }

    public function getTotalPagoCuota(): string
    {

        $subtotal = 0.0;
        foreach ($this->pagoCuotaDetalles as $pcd){
            $subtotal = $subtotal + $pcd->getImporte();
        }
        return sprintf("%.2f", $subtotal );
    } 

    public function getCuotas()
    {
        $tmp = "";
        foreach($this->pagoCuotaDetalles as $pcd)
        {
            $tmp = $tmp . "Abonado: " . $pcd->getImporte() . " de Cuota: " . $pcd->getCuota()->getAsignarCuota()->getPeriodo() . ". ";
        }
        return $tmp;
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
            $pagoCuotaDetalle->setPagocuota($this);
        }

        return $this;
    }

    public function removePagoCuotaDetalle(PagoCuotaDetalle $pagoCuotaDetalle): static
    {
        if ($this->pagoCuotaDetalles->removeElement($pagoCuotaDetalle)) {
            // set the owning side to null (unless already changed)
            if ($pagoCuotaDetalle->getPagocuota() === $this) {
                $pagoCuotaDetalle->setPagocuota(null);
            }
        }

        return $this;
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

    public function getTotal(): ?string
    {
        return $this->total;
    }

    public function setTotal(string $total): static
    {
        $this->total = $total;

        return $this;
    }

}
