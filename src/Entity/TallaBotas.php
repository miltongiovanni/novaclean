<?php

namespace App\Entity;

use App\Repository\TallaBotasRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TallaBotasRepository::class)]
class TallaBotas
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $talla = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTalla(): ?string
    {
        return $this->talla;
    }

    public function setTalla(string $talla): self
    {
        $this->talla = $talla;

        return $this;
    }
}
