<?php

namespace App\Entity;

use App\Repository\ParticularRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParticularRepository::class)]
class Particular
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $apellido = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $dni = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $direccion = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $telefono = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $fecha_nacimiento = null;

    #[ORM\OneToOne(mappedBy: 'particular', cascade: ['persist', 'remove'])]
    private ?Socio $socio = null;

    public function __toString(): string
    {
        $nombre = "";
        $apellido = "";
        $dni = "";

        $nombre = $this->getNombre() ?? "";
        $apellido = $this->getApellido() ?? "";
        $dni = $this->getDni() ?? "";

        return strval($apellido . " " . $nombre . " " . $dni);
    }

    public function getApeNom(): string
    {
        $nombre = "";
        $apellido = "";

        $nombre = $this->getNombre() ?? "";
        $apellido = $this->getApellido() ?? "";

        return strval($apellido . ", " . $nombre);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getApellido(): ?string
    {
        return $this->apellido;
    }

    public function setApellido(?string $apellido): static
    {
        $this->apellido = $apellido;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(?string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getDni(): ?string
    {
        return $this->dni;
    }

    public function setDni(?string $dni): static
    {
        $this->dni = $dni;

        return $this;
    }

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(?string $direccion): static
    {
        $this->direccion = $direccion;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(?string $telefono): static
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getFechaNacimiento(): ?\DateTime
    {
        return $this->fecha_nacimiento;
    }

    public function setFechaNacimiento(?\DateTime $fecha_nacimiento): static
    {
        $this->fecha_nacimiento = $fecha_nacimiento;

        return $this;
    }

    public function getSocio(): ?Socio
    {
        return $this->socio;
    }

    public function setSocio(?Socio $socio): static
    {
        // unset the owning side of the relation if necessary
        if ($socio === null && $this->socio !== null) {
            $this->socio->setParticular(null);
        }

        // set the owning side of the relation if necessary
        if ($socio !== null && $socio->getParticular() !== $this) {
            $socio->setParticular($this);
        }

        $this->socio = $socio;

        return $this;
    }
}
