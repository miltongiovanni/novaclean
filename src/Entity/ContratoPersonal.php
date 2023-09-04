<?php

namespace App\Entity;

use App\Repository\ContratoPersonalRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContratoPersonalRepository::class)]
class ContratoPersonal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'contratoPersonals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Personal $personal = null;

    #[ORM\ManyToOne(inversedBy: 'contratos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Contrato $contrato = null;

    #[ORM\Column]
    private ?int $salario_basico = null;

    #[ORM\Column(nullable: true)]
    private ?int $bono = null;


    #[ORM\ManyToOne(inversedBy: 'contratoPersonals')]
    #[ORM\JoinColumn(nullable: true)]
    private ?TipoNomina $tipo_nomina = null;
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

}
