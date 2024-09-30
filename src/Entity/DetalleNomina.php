<?php

namespace App\Entity;

use App\Repository\DetalleNominaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetalleNominaRepository::class)]
class DetalleNomina
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'detalleNomina')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Nomina $nomina = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Personal $personal = null;

    #[ORM\Column(nullable: true)]
    private ?float $sueldo_basico = null;

    #[ORM\Column]
    private ?int $dias_laborados = null;

    #[ORM\Column]
    private ?int $dias_transporte = null;

    #[ORM\Column]
    private ?int $dias_incapacidad = null;

    #[ORM\Column]
    private ?int $horas_extras_domingo = null;

    #[ORM\Column]
    private ?int $horas_extras_domingo_comp = null;

    #[ORM\Column]
    private ?int $auxilio_alimentacion = null;

    #[ORM\Column]
    private ?int $auxilio_transporte = null;

    #[ORM\Column]
    private ?int $anticipo = null;

    #[ORM\Column]
    private ?int $prestamo = null;

    #[ORM\Column]
    private ?int $coorserpark = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomina(): ?Nomina
    {
        return $this->nomina;
    }

    public function setNomina(?Nomina $nomina): static
    {
        $this->nomina = $nomina;

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

    public function getSueldoBasico(): ?float
    {
        return $this->sueldo_basico;
    }

    public function setSueldoBasico(?float $sueldo_basico): static
    {
        $this->sueldo_basico = $sueldo_basico;

        return $this;
    }

    public function getDiasLaborados(): ?int
    {
        return $this->dias_laborados;
    }

    public function setDiasLaborados(int $dias_laborados): static
    {
        $this->dias_laborados = $dias_laborados;

        return $this;
    }

    public function getDiasTransporte(): ?int
    {
        return $this->dias_transporte;
    }

    public function setDiasTransporte(int $dias_transporte): static
    {
        $this->dias_transporte = $dias_transporte;

        return $this;
    }

    public function getDiasIncapacidad(): ?int
    {
        return $this->dias_incapacidad;
    }

    public function setDiasIncapacidad(int $dias_incapacidad): static
    {
        $this->dias_incapacidad = $dias_incapacidad;

        return $this;
    }

    public function getHorasExtrasDomingo(): ?int
    {
        return $this->horas_extras_domingo;
    }

    public function setHorasExtrasDomingo(int $horas_extras_domingo): static
    {
        $this->horas_extras_domingo = $horas_extras_domingo;

        return $this;
    }

    public function getHorasExtrasDomingoComp(): ?int
    {
        return $this->horas_extras_domingo_comp;
    }

    public function setHorasExtrasDomingoComp(int $horas_extras_domingo_comp): static
    {
        $this->horas_extras_domingo_comp = $horas_extras_domingo_comp;

        return $this;
    }

    public function getAuxilioAlimentacion(): ?int
    {
        return $this->auxilio_alimentacion;
    }

    public function setAuxilioAlimentacion(int $auxilio_alimentacion): static
    {
        $this->auxilio_alimentacion = $auxilio_alimentacion;

        return $this;
    }

    public function getAuxilioTransporte(): ?int
    {
        return $this->auxilio_transporte;
    }

    public function setAuxilioTransporte(int $auxilio_transporte): static
    {
        $this->auxilio_transporte = $auxilio_transporte;

        return $this;
    }

    public function getAnticipo(): ?int
    {
        return $this->anticipo;
    }

    public function setAnticipo(int $anticipo): static
    {
        $this->anticipo = $anticipo;

        return $this;
    }

    public function getPrestamo(): ?int
    {
        return $this->prestamo;
    }

    public function setPrestamo(int $prestamo): static
    {
        $this->prestamo = $prestamo;

        return $this;
    }

    public function getCoorserpark(): ?int
    {
        return $this->coorserpark;
    }

    public function setCoorserpark(int $coorserpark): static
    {
        $this->coorserpark = $coorserpark;

        return $this;
    }
}
