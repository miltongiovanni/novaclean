<?php

namespace App\Entity;

use App\Repository\NominaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NominaRepository::class)]
class Nomina
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?TipoNomina $tipo_nomina = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha_inicio = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha_fin = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $preparado_por = null;

    #[ORM\ManyToOne]
    private ?User $aprobado_por = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha_preparation = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fecha_aprobacion = null;

    /**
     * @var Collection<int, DetalleNomina>
     */
    #[ORM\OneToMany(mappedBy: 'nomina', targetEntity: DetalleNomina::class)]
    private Collection $detalleNomina;

    public function __construct()
    {
        $this->detalleNomina = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTipoNomina(): ?TipoNomina
    {
        return $this->tipo_nomina;
    }

    public function setTipoNomina(?TipoNomina $tipo_nomina): static
    {
        $this->tipo_nomina = $tipo_nomina;

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

    public function getPreparadoPor(): ?User
    {
        return $this->preparado_por;
    }

    public function setPreparadoPor(?User $preparado_por): static
    {
        $this->preparado_por = $preparado_por;

        return $this;
    }

    public function getAprobadoPor(): ?User
    {
        return $this->aprobado_por;
    }

    public function setAprobadoPor(?User $aprobado_por): static
    {
        $this->aprobado_por = $aprobado_por;

        return $this;
    }

    public function getFechaPreparation(): ?\DateTimeInterface
    {
        return $this->fecha_preparation;
    }

    public function setFechaPreparation(\DateTimeInterface $fecha_preparation): static
    {
        $this->fecha_preparation = $fecha_preparation;

        return $this;
    }

    public function getFechaAprobacion(): ?\DateTimeInterface
    {
        return $this->fecha_aprobacion;
    }

    public function setFechaAprobacion(?\DateTimeInterface $fecha_aprobacion): static
    {
        $this->fecha_aprobacion = $fecha_aprobacion;

        return $this;
    }

    /**
     * @return Collection<int, DetalleNomina>
     */
    public function getDetalleNomina(): Collection
    {
        return $this->detalleNomina;
    }

    public function addDetalleNomina(DetalleNomina $detalleNomina): static
    {
        if (!$this->detalleNomina->contains($detalleNomina)) {
            $this->detalleNomina->add($detalleNomina);
            $detalleNomina->setNomina($this);
        }

        return $this;
    }

    public function removeDetalleNomina(DetalleNomina $detalleNomina): static
    {
        if ($this->detalleNomina->removeElement($detalleNomina)) {
            // set the owning side to null (unless already changed)
            if ($detalleNomina->getNomina() === $this) {
                $detalleNomina->setNomina(null);
            }
        }

        return $this;
    }
}
