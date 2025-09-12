<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;


#[ORM\Entity]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\GeneratedValue]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, unique: true)]
    private ?string $email = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $password = null;

    #[ORM\Column(type: Types::JSON)]
    private array $roles = [];

    private UserPasswordHasherInterface $passwordHasher;

    /**
     * @var Collection<int, Socio>
     */
    #[ORM\OneToMany(targetEntity: Socio::class, mappedBy: 'user')]
    private Collection $socios;

    /**
     * @var Collection<int, Cuota>
     */
    #[ORM\OneToMany(targetEntity: Cuota::class, mappedBy: 'user')]
    private Collection $cuotas;

    public function __toString(): string
    {
        return strval($this->getEmail());
    }

    public function __construct()
    {
        $this->socios = new ArrayCollection();
        $this->cuotas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getNewPassword(): ?string
    {
        return null;
    }

    public function setNewPassword(?string $newpassword): self
    {
        return $this;
    }    

    public function getRoles(): array
    {
        $roles = $this->roles;
        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    public function getRol()
    {
        return $this->roles[0];
    }

    public function setRol(string $rol)
    {
        $this->roles[0] = $rol;

        return $this->roles[0];
    }     

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function eraseCredentials(): void
    {
        // Si almacenas datos temporales sensibles en el usuario, límpialos aquí
    }

    /**
     * @return Collection<int, Socio>
     */
    public function getSocios(): Collection
    {
        return $this->socios;
    }

    public function addSocio(Socio $socio): static
    {
        if (!$this->socios->contains($socio)) {
            $this->socios->add($socio);
            $socio->setUser($this);
        }

        return $this;
    }

    public function removeSocio(Socio $socio): static
    {
        if ($this->socios->removeElement($socio)) {
            // set the owning side to null (unless already changed)
            if ($socio->getUser() === $this) {
                $socio->setUser(null);
            }
        }

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
            $cuota->setUser($this);
        }

        return $this;
    }

    public function removeCuota(Cuota $cuota): static
    {
        if ($this->cuotas->removeElement($cuota)) {
            // set the owning side to null (unless already changed)
            if ($cuota->getUser() === $this) {
                $cuota->setUser(null);
            }
        }

        return $this;
    }
}
