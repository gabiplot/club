<?php

namespace App\Entity;

use App\Repository\SocioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    //#[ORM\OneToOne(inversedBy: 'socio', cascade: ['persist', 'remove'])]
    #[ORM\OneToOne(inversedBy: 'socio', cascade: ['persist'])]
    private ?Particular $particular = null;

    /**
     * @var Collection<int, Cuota>
     */
    #[ORM\OneToMany(targetEntity: Cuota::class, mappedBy: 'socio')]
    private Collection $cuotas;

    #[ORM\ManyToOne(inversedBy: 'socios')]
    private ?Categoria $categoria = null;

    public function __construct()
    {
        $this->cuotas = new ArrayCollection();
    }

    public function __toString(): string
    {
        $nombre = "";
        $apellido = "";

        if($this->particular){
            $nombre = $this->particular->getNombre() ?? "";
            $apellido = $this->particular->getDni() ?? "";
        }

        return strval($nombre. " " . $apellido);
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

    public function getParticular(): ?Particular
    {
        return $this->particular;
    }

    public function setParticular(?Particular $particular): static
    {
        $this->particular = $particular;

        return $this;
    }

    /**
     * @return Collection<int, Cuota>
     */
    public function getCuotas(): Collection
    {
        return $this->cuotas;
    }

    public function addCuota(Cuota $cuota): static
    {
        if (!$this->cuotas->contains($cuota)) {
            $this->cuotas->add($cuota);
            $cuota->setSocio($this);
        }

        return $this;
    }

    public function removeCuota(Cuota $cuota): static
    {
        if ($this->cuotas->removeElement($cuota)) {
            // set the owning side to null (unless already changed)
            if ($cuota->getSocio() === $this) {
                $cuota->setSocio(null);
            }
        }

        return $this;
    }

    public function getCategoria(): ?Categoria
    {
        return $this->categoria;
    }

    public function setCategoria(?Categoria $categoria): static
    {
        $this->categoria = $categoria;

        return $this;
    }
}
