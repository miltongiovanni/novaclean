<?php

namespace App\Entity;

use App\Repository\ClienteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: ClienteRepository::class)]
class Cliente
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nit = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $direccion = null;

    #[ORM\Column(nullable: true)]
    private ?string $telefono = null;

    #[ORM\Column(length: 255)]
    private ?string $contacto = null;

    #[ORM\Column(nullable: true)]
    private ?string $celular = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $correo_electronico = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $observaciones = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $f_creacion = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $f_actualizacion = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'cliente', targetEntity: Contrato::class)]
    private Collection $contratos;

    #[ORM\Column]
    private ?bool $estado = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $telefono2 = null;

    #[ORM\Column(type: 'uuid', nullable: true)]
    private ?Uuid $slug;

    public function __construct()
    {
        $this->contratos = new ArrayCollection();
        $this->slug = Uuid::v6();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNit(): ?string
    {
        return $this->nit;
    }

    public function setNit(string $nit): self
    {
        $this->nit = $nit;

        return $this;
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

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(string $direccion): self
    {
        $this->direccion = $direccion;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getContacto(): ?string
    {
        return $this->contacto;
    }

    public function setContacto(string $contacto): self
    {
        $this->contacto = $contacto;

        return $this;
    }

    public function getCelular(): ?string
    {
        return $this->celular;
    }

    public function setCelular(?string $celular): self
    {
        $this->celular = $celular;

        return $this;
    }

    public function getCorreoElectronico(): ?string
    {
        return $this->correo_electronico;
    }

    public function setCorreoElectronico(?string $correo_electronico): self
    {
        $this->correo_electronico = $correo_electronico;

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

    public function getFCreacion(): ?\DateTimeInterface
    {
        return $this->f_creacion;
    }

    public function setFCreacion(\DateTimeInterface $f_creacion): self
    {
        $this->f_creacion = $f_creacion;

        return $this;
    }

    public function getFActualizacion(): ?\DateTimeInterface
    {
        return $this->f_actualizacion;
    }

    public function setFActualizacion(\DateTimeInterface $f_actualizacion): self
    {
        $this->f_actualizacion = $f_actualizacion;

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

    /**
     * @return Collection<int, Contrato>
     */
    public function getContratos(): Collection
    {
        return $this->contratos;
    }

    public function addContrato(Contrato $contrato): self
    {
        if (!$this->contratos->contains($contrato)) {
            $this->contratos->add($contrato);
            $contrato->setCliente($this);
        }

        return $this;
    }

    public function removeContrato(Contrato $contrato): self
    {
        if ($this->contratos->removeElement($contrato)) {
            // set the owning side to null (unless already changed)
            if ($contrato->getCliente() === $this) {
                $contrato->setCliente(null);
            }
        }

        return $this;
    }

    public function isEstado(): ?bool
    {
        return $this->estado;
    }

    public function setEstado(bool $estado): self
    {
        $this->estado = $estado;

        return $this;
    }

    public function getTelefono2(): ?string
    {
        return $this->telefono2;
    }

    public function setTelefono2(?string $telefono2): self
    {
        $this->telefono2 = $telefono2;

        return $this;
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

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'nit' => $this->getNit(),
            'nombre' => $this->getNombre(),
            'direccion' => $this->getDireccion(),
            'telefono' => $this->getTelefono(),
            'contacto' => $this->getContacto(),
            'celular' => $this->getCelular(),
            'correo_electronico' => $this->getCorreoElectronico(),
            'observaciones' => $this->getObservaciones(),
            'f_creacion' => $this->getFCreacion()->format('d/m/Y'),
            'f_actualizacion' => $this->getFActualizacion()->format('d/m/Y'),
            'modificado_por' => $this->getUser()->getNombre().' '.$this->getUser()->getApellido(),
            'estado' => $this->isEstado(),
            'telefono2' => $this->getTelefono2(),
            'slug' => $this->getSlug()->toRfc4122()
        ];
    }
    public function toArrayExport()
    {
        return [
            'Id' => $this->getId(),
            'Nit' => $this->getNit(),
            'Nombre' => $this->getNombre(),
            'Dirección' => $this->getDireccion(),
            'Teléfono 1' => $this->getTelefono(),
            'Contacto' => $this->getContacto(),
            'Celular' => $this->getCelular(),
            'Correo electrónico' => $this->getCorreoElectronico(),
            'Fecha creación' => $this->getFCreacion()->format('d/m/Y'),
            'Fecha actualización' => $this->getFActualizacion()->format('d/m/Y'),
            'Estado' => $this->isEstado() ? 'Activo' : 'Inactivo',
            'Teléfono 2' => $this->getTelefono2(),
            'Observaciones' => $this->getObservaciones()
        ];
    }
}
