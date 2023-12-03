<?php

namespace App\Entity;

use App\Repository\ContratoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: ContratoRepository::class)]
class Contrato
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $n_contrato = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $f_inicio = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $f_fin = null;

    #[ORM\Column]
    private ?bool $poliza_salario = null;

    #[ORM\Column]
    private ?bool $poliza_cumplimiento = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $n_poliza = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $aseguradora = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $vencimiento_poliza = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $observaciones = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'contratos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cliente $cliente = null;

    #[ORM\ManyToOne(inversedBy: 'contratos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Personal $personal = null;

    #[ORM\OneToMany(mappedBy: 'contrato', targetEntity: ContratoPersonal::class)]
    private Collection $contratoPersonals;

    #[ORM\Column(type: UuidType::NAME, nullable: true)]
    private ?Uuid $slug;

    public function __construct()
    {
        $this->contratoPersonals = new ArrayCollection();
        $this->slug = Uuid::v7();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNContrato(): ?string
    {
        return $this->n_contrato;
    }

    public function setNContrato(string $n_contrato): self
    {
        $this->n_contrato = $n_contrato;

        return $this;
    }

    public function getFInicio(): ?\DateTimeInterface
    {
        return $this->f_inicio;
    }

    public function setFInicio(\DateTimeInterface $f_inicio): self
    {
        $this->f_inicio = $f_inicio;

        return $this;
    }

    public function getFFin(): ?\DateTimeInterface
    {
        return $this->f_fin;
    }

    public function setFFin(\DateTimeInterface $f_fin): self
    {
        $this->f_fin = $f_fin;

        return $this;
    }

    public function isPolizaSalario(): ?bool
    {
        return $this->poliza_salario;
    }

    public function setPolizaSalario(bool $poliza_salario): self
    {
        $this->poliza_salario = $poliza_salario;

        return $this;
    }

    public function isPolizaCumplimiento(): ?bool
    {
        return $this->poliza_cumplimiento;
    }

    public function setPolizaCumplimiento(bool $poliza_cumplimiento): self
    {
        $this->poliza_cumplimiento = $poliza_cumplimiento;

        return $this;
    }

    public function getNPoliza(): ?string
    {
        return $this->n_poliza;
    }

    public function setNPoliza(?string $n_poliza): self
    {
        $this->n_poliza = $n_poliza;

        return $this;
    }

    public function getAseguradora(): ?string
    {
        return $this->aseguradora;
    }

    public function setAseguradora(?string $aseguradora): self
    {
        $this->aseguradora = $aseguradora;

        return $this;
    }

    public function getVencimientoPoliza(): ?\DateTimeInterface
    {
        return $this->vencimiento_poliza;
    }

    public function setVencimientoPoliza(?\DateTimeInterface $vencimiento_poliza): self
    {
        $this->vencimiento_poliza = $vencimiento_poliza;

        return $this;
    }

    public function getObservaciones(): ?string
    {
        return $this->observaciones;
    }

    public function setObservaciones(?string $observaciones): self
    {
        $this->observaciones = $observaciones;

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

    public function getCliente(): ?Cliente
    {
        return $this->cliente;
    }

    public function setCliente(?Cliente $cliente): self
    {
        $this->cliente = $cliente;

        return $this;
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

    /**
     * @return Collection<int, ContratoPersonal>
     */
    public function getContratoPersonals(): Collection
    {
        return $this->contratoPersonals;
    }

    public function addContratoPersonal(ContratoPersonal $contratoPersonal): self
    {
        if (!$this->contratoPersonals->contains($contratoPersonal)) {
            $this->contratoPersonals->add($contratoPersonal);
            $contratoPersonal->setContrato($this);
        }

        return $this;
    }

    public function removeContratoPersonal(ContratoPersonal $contratoPersonal): self
    {
        if ($this->contratoPersonals->removeElement($contratoPersonal)) {
            // set the owning side to null (unless already changed)
            if ($contratoPersonal->getContrato() === $this) {
                $contratoPersonal->setContrato(null);
            }
        }

        return $this;
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'cliente_id' => $this->getCliente()->getId(),
            'cliente' => $this->getCliente()->getNombre(),
            'supervisor_id' => $this->getPersonal()->getId(),
            'supervisor' => $this->getPersonal()->getNombre() . ' ' . $this->getPersonal()->getApellido(),
            'contrato_id' => $this->getNContrato(),
            'f_inicio' => $this->getFInicio()->format('d/m/Y'),
            'f_fin' => $this->getFFin()->format('d/m/Y'),
            'tiene_poliza_salario' => $this->isPolizaSalario(),
            'tiene_poliza_cumplimiento' => $this->isPolizaCumplimiento(),
            'no_poliza' => $this->getNPoliza() ?? '',
            'aseguradora' => $this->getAseguradora() ?? '',
            'vencimiento_poliza' => $this->getVencimientoPoliza() ? $this->getVencimientoPoliza()->format('d/m/Y') : null,
            'observaciones' => $this->getObservaciones() ?? '',
            'slug' => $this->getSlug()->toRfc4122(),
        ];
    }

    public function getSlug(): ?Uuid
    {
        return $this->slug;
    }

    public function setSlug(?Uuid $slug): static
    {
        $this->slug = $slug;

        return $this;
    }
}
