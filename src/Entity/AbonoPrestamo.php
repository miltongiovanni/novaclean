<?php

namespace App\Entity;

use App\Repository\AbonoPrestamoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AbonoPrestamoRepository::class)]
class AbonoPrestamo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'abonoPrestamos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Prestamo $prestamo = null;

    #[ORM\Column]
    private ?int $abono = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha_abono = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrestamo(): ?Prestamo
    {
        return $this->prestamo;
    }

    public function setPrestamo(?Prestamo $prestamo): static
    {
        $this->prestamo = $prestamo;

        return $this;
    }

    public function getAbono(): ?int
    {
        return $this->abono;
    }

    public function setAbono(int $abono): static
    {
        $this->abono = $abono;

        return $this;
    }

    public function getFechaAbono(): ?\DateTimeInterface
    {
        return $this->fecha_abono;
    }

    public function setFechaAbono(\DateTimeInterface $fecha_abono): static
    {
        $this->fecha_abono = $fecha_abono;

        return $this;
    }
}
