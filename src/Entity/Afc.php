<?php

namespace App\Entity;

use App\Repository\AfcRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AfcRepository::class)]
class Afc
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $contacto = null;

    #[ORM\Column(nullable: true)]
    private ?int $telefono = null;

    #[ORM\Column(nullable: true)]
    private ?int $extension = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fecha_creation = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fecha_actualizacion = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(nullable: true)]
    private ?int $celular = null;

    #[ORM\OneToMany(mappedBy: 'afc', targetEntity: Personal::class)]
    private Collection $personals;

    public function __construct()
    {
        $this->personals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getContacto(): ?string
    {
        return $this->contacto;
    }

    public function setContacto(?string $contacto): self
    {
        $this->contacto = $contacto;

        return $this;
    }

    public function getTelefono(): ?int
    {
        return $this->telefono;
    }

    public function setTelefono(?int $telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getExtension(): ?int
    {
        return $this->extension;
    }

    public function setExtension(?int $extension): self
    {
        $this->extension = $extension;

        return $this;
    }

    public function getFechaCreation(): ?\DateTimeInterface
    {
        return $this->fecha_creation;
    }

    public function setFechaCreation(?\DateTimeInterface $fecha_creation): self
    {
        $this->fecha_creation = $fecha_creation;

        return $this;
    }

    public function getFechaActualizacion(): ?\DateTimeInterface
    {
        return $this->fecha_actualizacion;
    }

    public function setFechaActualizacion(?\DateTimeInterface $fecha_actualizacion): self
    {
        $this->fecha_actualizacion = $fecha_actualizacion;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCelular(): ?int
    {
        return $this->celular;
    }

    public function setCelular(?int $celular): self
    {
        $this->celular = $celular;

        return $this;
    }

    /**
     * @return Collection<int, Personal>
     */
    public function getPersonals(): Collection
    {
        return $this->personals;
    }

    public function addPersonal(Personal $personal): self
    {
        if (!$this->personals->contains($personal)) {
            $this->personals->add($personal);
            $personal->setAfc($this);
        }

        return $this;
    }

    public function removePersonal(Personal $personal): self
    {
        if ($this->personals->removeElement($personal)) {
            // set the owning side to null (unless already changed)
            if ($personal->getAfc() === $this) {
                $personal->setAfc(null);
            }
        }

        return $this;
    }
}