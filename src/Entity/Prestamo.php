<?php

namespace App\Entity;

use App\Repository\PrestamoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PrestamoRepository::class)]
class Prestamo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $monto = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha_prestamo = null;

    #[ORM\ManyToOne(inversedBy: 'prestamos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Personal $personal = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $responsable = null;

    #[ORM\Column(length: 255)]
    private ?string $estado = null;

    #[ORM\OneToMany(mappedBy: 'prestamo', targetEntity: AbonoPrestamo::class)]
    private Collection $abonoPrestamos;

    public function __construct()
    {
        $this->abonoPrestamos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMonto(): ?int
    {
        return $this->monto;
    }

    public function setMonto(int $monto): static
    {
        $this->monto = $monto;

        return $this;
    }

    public function getFechaPrestamo(): ?\DateTimeInterface
    {
        return $this->fecha_prestamo;
    }

    public function setFechaPrestamo(\DateTimeInterface $fecha_prestamo): static
    {
        $this->fecha_prestamo = $fecha_prestamo;

        return $this;
    }

    public function getPersonal(): ?Personal
    {
        return $this->personal;
    }

    public function setPersonal(?Personal $personal): static
    {
        $this->personal = $personal;

        return $this;
    }

    public function getResponsable(): ?User
    {
        return $this->responsable;
    }

    public function setResponsable(?User $responsable): static
    {
        $this->responsable = $responsable;

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

    /**
     * @return Collection<int, AbonoPrestamo>
     */
    public function getAbonoPrestamos(): Collection
    {
        return $this->abonoPrestamos;
    }

    public function addAbonoPrestamo(AbonoPrestamo $abonoPrestamo): static
    {
        if (!$this->abonoPrestamos->contains($abonoPrestamo)) {
            $this->abonoPrestamos->add($abonoPrestamo);
            $abonoPrestamo->setPrestamo($this);
        }

        return $this;
    }

    public function removeAbonoPrestamo(AbonoPrestamo $abonoPrestamo): static
    {
        if ($this->abonoPrestamos->removeElement($abonoPrestamo)) {
            // set the owning side to null (unless already changed)
            if ($abonoPrestamo->getPrestamo() === $this) {
                $abonoPrestamo->setPrestamo(null);
            }
        }

        return $this;
    }
}
