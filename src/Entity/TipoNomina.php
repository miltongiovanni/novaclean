<?php

namespace App\Entity;

use App\Repository\TipoNominaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TipoNominaRepository::class)]
class TipoNomina
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\OneToMany(mappedBy: 'tipo_nomina', targetEntity: ContratoPersonal::class)]
    private Collection $contratoPersonals;

    public function __construct()
    {
        $this->contratoPersonals = new ArrayCollection();
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

    /**
     * @return Collection<int, Personal>
     */
    public function getContratoPersonals(): Collection
    {
        return $this->contratoPersonals;
    }

    public function addContratoPersonal(ContratoPersonal $contratoPersonal): self
    {
        if (!$this->contratoPersonals->contains($contratoPersonal)) {
            $this->contratoPersonals->add($contratoPersonal);
            $contratoPersonal->setTipoNomina($this);
        }

        return $this;
    }

    public function removeContratoPersonal(ContratoPersonal $contratoPersonal): self
    {
        if ($this->contratoPersonals->removeElement($contratoPersonal)) {
            // set the owning side to null (unless already changed)
            if ($contratoPersonal->getTipoNomina() === $this) {
                $contratoPersonal->setTipoNomina(null);
            }
        }

        return $this;
    }
}
