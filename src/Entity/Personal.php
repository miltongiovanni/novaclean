<?php

namespace App\Entity;

use App\Repository\PersonalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: PersonalRepository::class)]
class Personal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $identificacion = null;

    #[ORM\Column(length: 255)]
    private ?string $lugar_expedicion = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $apellido = null;

    #[ORM\Column(length: 255)]
    private ?string $numero_cuenta = null;

    #[ORM\Column(length: 255)]
    private ?string $direccion = null;

    #[ORM\Column(nullable: true)]
    private ?string $telefono = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $correo_electronico = null;

    #[ORM\Column(nullable: true)]
    private ?string $celular = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $f_nacimiento = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $f_ingreso = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $f_examen_ingreso = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Sexo $sexo = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Afp $afp = null;

    #[ORM\ManyToOne(inversedBy: 'personals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Eps $eps = null;

    #[ORM\ManyToOne(inversedBy: 'personals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Afc $afc = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?TipoCuenta $tipo_cuenta = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?TallaUniforme $talla_uniforme = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?TallaBotas $talla_botas = null;

    #[ORM\ManyToOne(inversedBy: 'personals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cargo $cargo = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?TallaGuantes $talla_guantes = null;

    #[ORM\ManyToOne(inversedBy: 'personals')]
    private ?CursoEspecializado $curso_especializado = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?TallaCamisa $talla_camisa = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?TallaPantalon $talla_pantalon = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?TallaCalzado $talla_calzado = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'personal', targetEntity: Contrato::class)]
    private Collection $contratos;

    #[ORM\OneToMany(mappedBy: 'personal', targetEntity: ContratoPersonal::class)]
    private Collection $contratoPersonals;

    #[ORM\Column]
    private ?bool $activo = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fecha_creacion = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fecha_actualizacion = null;

    #[ORM\Column(type: 'uuid', nullable: true)]
    private ?Uuid $slug;

    #[ORM\Column(nullable: true)]
    private ?int $coorserpark = null;

    #[ORM\OneToMany(mappedBy: 'personal', targetEntity: Prestamo::class)]
    private Collection $prestamos;

    #[ORM\OneToMany(mappedBy: 'personal_id', targetEntity: NovedadNomina::class)]
    private Collection $novedadesNominas;

    public function __construct()
    {
        $this->contratos = new ArrayCollection();
        $this->contratoPersonals = new ArrayCollection();
        $this->slug = Uuid::v6();
        $this->prestamos = new ArrayCollection();
        $this->novedadesNominas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdentificacion(): ?string
    {
        return $this->identificacion;
    }

    public function setIdentificacion(string $identificacion): self
    {
        $this->identificacion = $identificacion;

        return $this;
    }

    public function getLugarExpedicion(): ?string
    {
        return $this->lugar_expedicion;
    }

    public function setLugarExpedicion(string $lugar_expedicion): self
    {
        $this->lugar_expedicion = $lugar_expedicion;

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

    public function getApellido(): ?string
    {
        return $this->apellido;
    }

    public function setApellido(string $apellido): self
    {
        $this->apellido = $apellido;

        return $this;
    }

    public function getNumeroCuenta(): ?string
    {
        return $this->numero_cuenta;
    }

    public function setNumeroCuenta(string $numero_cuenta): self
    {
        $this->numero_cuenta = $numero_cuenta;

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

    public function setTelefono(?string $telefono): self
    {
        $this->telefono = $telefono;

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

    public function getCelular(): ?string
    {
        return $this->celular;
    }

    public function setCelular(?string $celular): self
    {
        $this->celular = $celular;

        return $this;
    }

    public function getFNacimiento(): ?\DateTimeInterface
    {
        return $this->f_nacimiento;
    }

    public function setFNacimiento(\DateTimeInterface $f_nacimiento): self
    {
        $this->f_nacimiento = $f_nacimiento;

        return $this;
    }

    public function getFIngreso(): ?\DateTimeInterface
    {
        return $this->f_ingreso;
    }

    public function setFIngreso(\DateTimeInterface $f_ingreso): self
    {
        $this->f_ingreso = $f_ingreso;

        return $this;
    }

    public function getFExamenIngreso(): ?\DateTimeInterface
    {
        return $this->f_examen_ingreso;
    }

    public function setFExamenIngreso(\DateTimeInterface $f_examen_ingreso): self
    {
        $this->f_examen_ingreso = $f_examen_ingreso;

        return $this;
    }

    public function getSexo(): ?Sexo
    {
        return $this->sexo;
    }

    public function setSexo(?Sexo $sexo): self
    {
        $this->sexo = $sexo;

        return $this;
    }

    public function getAfp(): ?Afp
    {
        return $this->afp;
    }

    public function setAfp(?Afp $afp): self
    {
        $this->afp = $afp;

        return $this;
    }

    public function getEps(): ?Eps
    {
        return $this->eps;
    }

    public function setEps(?Eps $eps): self
    {
        $this->eps = $eps;

        return $this;
    }

    public function getAfc(): ?Afc
    {
        return $this->afc;
    }

    public function setAfc(?Afc $afc): self
    {
        $this->afc = $afc;

        return $this;
    }

    public function getTipoCuenta(): ?TipoCuenta
    {
        return $this->tipo_cuenta;
    }

    public function setTipoCuenta(?TipoCuenta $tipo_cuenta): self
    {
        $this->tipo_cuenta = $tipo_cuenta;

        return $this;
    }

    public function getTallaUniforme(): ?TallaUniforme
    {
        return $this->talla_uniforme;
    }

    public function setTallaUniforme(?TallaUniforme $talla_uniforme): self
    {
        $this->talla_uniforme = $talla_uniforme;

        return $this;
    }

    public function getTallaBotas(): ?TallaBotas
    {
        return $this->talla_botas;
    }

    public function setTallaBotas(?TallaBotas $talla_botas): self
    {
        $this->talla_botas = $talla_botas;

        return $this;
    }

    public function getCargo(): ?Cargo
    {
        return $this->cargo;
    }

    public function setCargo(?Cargo $cargo): self
    {
        $this->cargo = $cargo;

        return $this;
    }

    public function getTallaGuantes(): ?TallaGuantes
    {
        return $this->talla_guantes;
    }

    public function setTallaGuantes(?TallaGuantes $talla_guantes): self
    {
        $this->talla_guantes = $talla_guantes;

        return $this;
    }

    public function getCursoEspecializado(): ?CursoEspecializado
    {
        return $this->curso_especializado;
    }

    public function setCursoEspecializado(?CursoEspecializado $curso_especializado): self
    {
        $this->curso_especializado = $curso_especializado;

        return $this;
    }

    public function getTallaCamisa(): ?TallaCamisa
    {
        return $this->talla_camisa;
    }

    public function setTallaCamisa(?TallaCamisa $talla_camisa): self
    {
        $this->talla_camisa = $talla_camisa;

        return $this;
    }

    public function getTallaPantalon(): ?TallaPantalon
    {
        return $this->talla_pantalon;
    }

    public function setTallaPantalon(?TallaPantalon $talla_pantalon): self
    {
        $this->talla_pantalon = $talla_pantalon;

        return $this;
    }

    public function getTallaCalzado(): ?TallaCalzado
    {
        return $this->talla_calzado;
    }

    public function setTallaCalzado(?TallaCalzado $talla_calzado): self
    {
        $this->talla_calzado = $talla_calzado;

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
            $contrato->setPersonal($this);
        }

        return $this;
    }

    public function removeContrato(Contrato $contrato): self
    {
        if ($this->contratos->removeElement($contrato)) {
            // set the owning side to null (unless already changed)
            if ($contrato->getPersonal() === $this) {
                $contrato->setPersonal(null);
            }
        }

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
            $contratoPersonal->setPersonal($this);
        }

        return $this;
    }

    public function removeContratoPersonal(ContratoPersonal $contratoPersonal): self
    {
        if ($this->contratoPersonals->removeElement($contratoPersonal)) {
            // set the owning side to null (unless already changed)
            if ($contratoPersonal->getPersonal() === $this) {
                $contratoPersonal->setPersonal(null);
            }
        }

        return $this;
    }

    public function isActivo(): ?bool
    {
        return $this->activo;
    }

    public function setActivo(bool $activo): self
    {
        $this->activo = $activo;

        return $this;
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'identificacion' => $this->getIdentificacion(),
            'lugar_expedicion' => $this->getLugarExpedicion(),
            'nombre' => $this->getNombre(),
            'apellido' => $this->getApellido(),
            'numero_cuenta' => $this->getNumeroCuenta(),
            'direccion' => $this->getDireccion(),
            'telefono' => $this->getTelefono(),
            'celular' => $this->getCelular(),
            'correo_electronico' => $this->getCorreoElectronico(),
            'f_nacimiento' => $this->getFNacimiento()->format('d/m/Y'),
            'f_ingreso' => $this->getFIngreso() != null ? $this->getFIngreso()->format('d/m/Y') : $this->getFIngreso(),
            'f_examen_ingreso' => $this->getFExamenIngreso() != null ? $this->getFExamenIngreso()->format('d/m/Y') : $this->getFExamenIngreso(),
            'sexo' => $this->getSexo()->getSexo(),
            'afp' => $this->getAfp()->getNombre(),
            'eps' => $this->getEps()->getNombre(),
            'afc' => $this->getAfc()->getNombre(),
            'tipo_cuenta' => $this->getTipoCuenta()->getNombre(),
            'talla_uniforme' => $this->getTallaUniforme() != null ? $this->getTallaUniforme()->getTalla() : $this->getTallaUniforme(),
            'talla_botas' => $this->getTallaBotas() != null ? $this->getTallaBotas()->getTalla() : $this->getTallaBotas(),
            'talla_pantalon' => $this->getTallaPantalon() != null ? $this->getTallaPantalon()->getTalla() : $this->getTallaPantalon(),
            'talla_calzado' => $this->getTallaCalzado() != null ? $this->getTallaCalzado()->getTalla() : $this->getTallaCalzado(),
            'cargo' => $this->getCargo()->getDescripcion(),
            'talla_guantes' => $this->getTallaGuantes() != null ? $this->getTallaGuantes()->getTalla() : $this->getTallaGuantes(),
            'curso_especializado' => $this->getCursoEspecializado() != null ? $this->getCursoEspecializado()->getNombre() : $this->getCursoEspecializado(),
            'activo' => $this->isActivo(),
            'estado' => $this->isActivo() == true ? '<i class="bi bi-check-circle-fill activo"></i>' : '<i class="bi bi-x-circle-fill inactivo"></i>',
            'slug' => $this->getSlug()->toRfc4122()
        ];
    }
    public function toExportArray()
    {
        $contratos_personal = $this->contratoPersonals->toArray();
        foreach ($contratos_personal as $contratoPersonal) {

        }

        return [
            'Id' => $this->getId(),
            'Identificación' => $this->getIdentificacion(),
            'Lugar de expedición' => $this->getLugarExpedicion(),
            'Nombre' => $this->getNombre(),
            'Apellido' => $this->getApellido(),
            'Cargo' => $this->getCargo()->getDescripcion(),
            'Número de cuenta' => $this->getNumeroCuenta(),
            'Dirección' => $this->getDireccion(),
            'Teléfono' => $this->getTelefono(),
            'Celular' => $this->getCelular(),
            'Correo electrónico' => $this->getCorreoElectronico(),
            'Fecha de nacimiento' => $this->getFNacimiento()->format('d/m/Y'),
            'Fecha de ingreso' => $this->getFIngreso() != null ? $this->getFIngreso()->format('d/m/Y') : $this->getFIngreso(),
            'Fecha examen de ingreso' => $this->getFExamenIngreso() != null ? $this->getFExamenIngreso()->format('d/m/Y') : $this->getFExamenIngreso(),
            'Sexo' => $this->getSexo()->getSexo(),
            'Afp' => $this->getAfp()->getNombre(),
            'Eps' => $this->getEps()->getNombre(),
            'Afc' => $this->getAfc()->getNombre(),
            'Tipo de cuenta' => $this->getTipoCuenta()->getNombre(),
            'Talla uniforme' => $this->getTallaUniforme() != null ? $this->getTallaUniforme()->getTalla() : $this->getTallaUniforme(),
            'Talla botas' => $this->getTallaBotas() != null ? $this->getTallaBotas()->getTalla() : $this->getTallaBotas(),
            'Talla pantalón' => $this->getTallaPantalon() != null ? $this->getTallaPantalon()->getTalla() : $this->getTallaPantalon(),
            'Talla calzado' => $this->getTallaCalzado() != null ? $this->getTallaCalzado()->getTalla() : $this->getTallaCalzado(),
            'Talla_guantes' => $this->getTallaGuantes() != null ? $this->getTallaGuantes()->getTalla() : $this->getTallaGuantes(),
            'Curso especializado' => $this->getCursoEspecializado() != null ? $this->getCursoEspecializado()->getNombre() : $this->getCursoEspecializado(),
            'Activo' => $this->isActivo(),
        ];
    }

    public function getFechaCreacion(): ?\DateTimeInterface
    {
        return $this->fecha_creacion;
    }

    public function setFechaCreacion(?\DateTimeInterface $fecha_creacion): self
    {
        $this->fecha_creacion = $fecha_creacion;

        return $this;
    }

    public function getFechaActualizacion(): ?\DateTimeInterface
    {
        return $this->fecha_actualizacion;
    }

    public function setFechaActualizacion(?\DateTimeInterface $fecha_actualizacion): self
    {
        $this->fecha_actualizacion = $fecha_actualizacion;

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

    public function getCoorserpark(): ?int
    {
        return $this->coorserpark;
    }

    public function setCoorserpark(?int $coorserpark): static
    {
        $this->coorserpark = $coorserpark;

        return $this;
    }

    /**
     * @return Collection<int, Prestamo>
     */
    public function getPrestamos(): Collection
    {
        return $this->prestamos;
    }

    public function addPrestamo(Prestamo $prestamo): static
    {
        if (!$this->prestamos->contains($prestamo)) {
            $this->prestamos->add($prestamo);
            $prestamo->setPersonal($this);
        }

        return $this;
    }

    public function removePrestamo(Prestamo $prestamo): static
    {
        if ($this->prestamos->removeElement($prestamo)) {
            // set the owning side to null (unless already changed)
            if ($prestamo->getPersonal() === $this) {
                $prestamo->setPersonal(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, NovedadNomina>
     */
    public function getNovedadesNominas(): Collection
    {
        return $this->novedadesNominas;
    }

    public function addNovedadesNomina(NovedadNomina $novedadesNomina): static
    {
        if (!$this->novedadesNominas->contains($novedadesNomina)) {
            $this->novedadesNominas->add($novedadesNomina);
            $novedadesNomina->setPersonalId($this);
        }

        return $this;
    }

    public function removeNovedadesNomina(NovedadNomina $novedadesNomina): static
    {
        if ($this->novedadesNominas->removeElement($novedadesNomina)) {
            // set the owning side to null (unless already changed)
            if ($novedadesNomina->getPersonalId() === $this) {
                $novedadesNomina->setPersonalId(null);
            }
        }

        return $this;
    }
}
