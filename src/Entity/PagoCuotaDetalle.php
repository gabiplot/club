<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PagoCuotaDetalleRepository;

//validaciones
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: PagoCuotaDetalleRepository::class)]
class PagoCuotaDetalle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'pagoCuotaDetalles')]
    private ?PagoCuota $pagocuota = null;

    #[ORM\ManyToOne(inversedBy: 'pagoCuotaDetalles')]
    private ?Cuota $cuota = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $importe = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $recargo = null;

    #[Assert\Callback]
    public function validateImporte(ExecutionContextInterface $context): void
    {
        if ($this->cuota === null){
            $context->buildViolation('Debe seleccionar al menos una cuota.')
                ->atPath('cuota')
                ->addViolation();
                return;
        }
        //dd("validate");
        $saldo = $this->cuota->getSaldo();        
        //dump((float) $saldo);
        //dump((float) $this->importe);
        //dump((float)$this->importe > (float) $saldo);
        if ($this->importe !== null && (float)$this->importe > (float) $saldo) {
            $context->buildViolation('El importe debe ser MENOR O IGUAL que el de la cuota')
                ->atPath('importe')
                ->addViolation();

        }
        //dump("no");
        //dd("finvalidate");
    }

    public function __toString(): string
    {

        return strval($this->id);
    }    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPagocuota(): ?PagoCuota
    {
        return $this->pagocuota;
    }

    public function setPagocuota(?PagoCuota $pagocuota): static
    {
        $this->pagocuota = $pagocuota;

        return $this;
    }

    public function getCuota(): ?Cuota
    {
        return $this->cuota;
    }

    public function setCuota(?Cuota $cuota): static
    {
        $this->cuota = $cuota;

        return $this;
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

    public function getRecargo(): ?string
    {
        return $this->recargo;
    }

    public function setRecargo(string $recargo): static
    {
        $this->recargo = $recargo;

        return $this;
    }
}
