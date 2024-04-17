<?php

namespace App\Entity;

use App\Repository\NovedadNominaRepository;
use Carbon\Carbon;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NovedadNominaRepository::class)]
class NovedadNomina
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'novedadesNominas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Personal $personal_id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?TipoNovedadNomina $tipo_novedad = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha_inicio = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha_fin = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $observaciones = null;

    #[ORM\Column]
    private ?bool $activa = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha_creacion = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha_actualizacion = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPersonalId(): ?Personal
    {
        return $this->personal_id;
    }

    public function setPersonalId(?Personal $personal_id): static
    {
        $this->personal_id = $personal_id;

        return $this;
    }

    public function getTipoNovedad(): ?TipoNovedadNomina
    {
        return $this->tipo_novedad;
    }

    public function setTipoNovedad(?TipoNovedadNomina $tipo_novedad): static
    {
        $this->tipo_novedad = $tipo_novedad;

        return $this;
    }

    public function getFechaInicio(): ?\DateTimeInterface
    {
        return $this->fecha_inicio;
    }

    public function setFechaInicio(\DateTimeInterface $fecha_inicio): static
    {
        $this->fecha_inicio = $fecha_inicio;

        return $this;
    }

    public function getFechaFin(): ?\DateTimeInterface
    {
        return $this->fecha_fin;
    }

    public function setFechaFin(\DateTimeInterface $fecha_fin): static
    {
        $this->fecha_fin = $fecha_fin;

        return $this;
    }

    public function getObservaciones(): ?string
    {
        return $this->observaciones;
    }

    public function setObservaciones(?string $observaciones): static
    {
        $this->observaciones = $observaciones;

        return $this;
    }
    public function toArray()
    {
        if (Carbon::parse($this->getFechaInicio()) == Carbon::parse($this->getFechaInicio())->startOfDay()){
            $fecha_inicio = $this->getFechaInicio()->format('Y-m-d');
        }else{
            $fecha_inicio = $this->getFechaInicio()->format('Y-m-d  h:i a');
        }
        if (Carbon::parse($this->getFechaFin()) == Carbon::parse($this->getFechaFin())->startOfDay()){
            $fecha_fin = $this->getFechaFin()->format('Y-m-d');
        }else{
            $fecha_fin = $this->getFechaFin()->format('Y-m-d  h:i a');
        }
        return [
            'id' => $this->getId(),
            'personal_id' => $this->getPersonalId()->getId(),
            'personal' => $this->getPersonalId()->getNombre(). ' ' . $this->getPersonalId()->getApellido(),
            'tipo_novedad_id' => $this->getTipoNovedad()->getId(),
            'tipo_novedad' => $this->getTipoNovedad()->getDescripcion(),
            'f_inicio' => $fecha_inicio,
            'f_fin' => $fecha_fin,
            'observaciones' => $this->getObservaciones() ?? '',
            'activa' => $this->isActiva(),
            'fecha_creacion' => $this->getFechaCreacion()->format('Y-m-d'),
            'fecha_actualizacion' => $this->getFechaActualizacion()->format('Y-m-d'),
        ];
    }

    public function isActiva(): ?bool
    {
        return $this->activa;
    }

    public function setActiva(bool $activa): static
    {
        $this->activa = $activa;

        return $this;
    }

    public function getFechaCreacion(): ?\DateTimeInterface
    {
        return $this->fecha_creacion;
    }

    public function setFechaCreacion(\DateTimeInterface $fecha_creacion): static
    {
        $this->fecha_creacion = $fecha_creacion;

        return $this;
    }

    public function getFechaActualizacion(): ?\DateTimeInterface
    {
        return $this->fecha_actualizacion;
    }

    public function setFechaActualizacion(\DateTimeInterface $fecha_actualizacion): static
    {
        $this->fecha_actualizacion = $fecha_actualizacion;

        return $this;
    }
}
