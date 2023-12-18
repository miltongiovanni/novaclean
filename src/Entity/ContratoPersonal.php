<?php

namespace App\Entity;

use App\Repository\ContratoPersonalRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContratoPersonalRepository::class)]
class ContratoPersonal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'contratoPersonals', targetEntity: Personal::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Personal $personal = null;

    #[ORM\ManyToOne(inversedBy: 'contratoPersonals', targetEntity: Contrato::class)]
    #[ORM\JoinColumn(nullable: false, name: 'id')]
    private ?Contrato $contrato = null;

    #[ORM\Column]
    private ?int $salario_basico = null;

    #[ORM\Column(nullable: true)]
    private ?int $bono = null;


    #[ORM\ManyToOne(inversedBy: 'contratoPersonals')]
    #[ORM\JoinColumn(nullable: true)]
    private ?TipoNomina $tipo_nomina = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fechaIngreso = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fechaRetiro = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPersonal(): ?Personal
    {
        return $this->personal;
    }

    public function setPersonal(?Personal $personal): self
    {
        $this->personal = $personal;

        return $this;
    }

    public function getContrato(): ?Contrato
    {
        return $this->contrato;
    }

    public function setContrato(?Contrato $contrato): self
    {
        $this->contrato = $contrato;

        return $this;
    }

    public function getSalarioBasico(): ?int
    {
        return $this->salario_basico;
    }

    public function setSalarioBasico(int $salario_basico): self
    {
        $this->salario_basico = $salario_basico;

        return $this;
    }

    public function getBono(): ?int
    {
        return $this->bono;
    }

    public function setBono(int $bono): self
    {
        $this->bono = $bono != 0 ? $bono : null;

        return $this;
    }

    public function getTipoNomina(): ?TipoNomina
    {
        return $this->tipo_nomina;
    }

    public function setTipoNomina(?TipoNomina $tipo_nomina): self
    {
        $this->tipo_nomina = $tipo_nomina;

        return $this;
    }

    public function getFechaIngreso(): ?\DateTimeInterface
    {
        return $this->fechaIngreso;
    }

    public function setFechaIngreso(\DateTimeInterface $fechaIngreso): static
    {
        $this->fechaIngreso = $fechaIngreso;

        return $this;
    }

    public function getFechaRetiro(): ?\DateTimeInterface
    {
        return $this->fechaRetiro;
    }

    public function setFechaRetiro(?\DateTimeInterface $fechaRetiro): static
    {
        $this->fechaRetiro = $fechaRetiro;

        return $this;
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'personal_id' => $this->personal->getId(),
            'nombre' => $this->personal->getNombre(),
            'apellido' => $this->personal->getApellido(),
            'cargo' => $this->personal->getCargo()->getDescripcion(),
            'activo' => $this->personal->isActivo(),
            'slug_personal' => $this->personal->getSlug()->toRfc4122(),
            'fechaIngreso' => $this->getFechaIngreso() != null ? $this->getFechaIngreso()->format('Y-m-d') : $this->getFechaIngreso(),
            'salario' => $this->getSalarioBasico(),
            'bono' => $this->getBono(),
            'tipo_nomina' => $this->getTipoNomina()->getNombre(),
            'tipo_nomina_id' => $this->getTipoNomina()->getId(),
            'contrato_id' => $this->contrato->getNContrato(),
            'contrato_cliente' => $this->contrato->getCliente()->getNombre(),
            'contrato_slug' => $this->contrato->getSlug()->toRfc4122(),
        ];

    }
}
