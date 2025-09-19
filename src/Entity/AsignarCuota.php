<?php

namespace App\Entity;

use App\Repository\AsignarCuotaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @var Collection<int, Cuota>
     */
    #[ORM\OneToMany(targetEntity: Cuota::class, mappedBy: 'asignarcuota', cascade: ['persist', 'remove'])]
    private Collection $cuotas;

    public function __construct()
    {
        $this->cuotas = new ArrayCollection();
    }

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
            $cuota->setAsignarcuota($this);
        }

        return $this;
    }

    public function removeCuota(Cuota $cuota): static
    {
        if ($this->cuotas->removeElement($cuota)) {
            // set the owning side to null (unless already changed)
            if ($cuota->getAsignarcuota() === $this) {
                $cuota->setAsignarcuota(null);
            }
        }

        return $this;
    }
}
