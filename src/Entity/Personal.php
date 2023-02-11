<?php

namespace App\Entity;

use App\Repository\PersonalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

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

    #[ORM\Column]
    private ?int $salario_basico = null;

    #[ORM\Column]
    private ?int $bono = null;

    #[ORM\Column(length: 255)]
    private ?string $direccion = null;

    #[ORM\Column(nullable: true)]
    private ?int $telefono = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $correo_electronico = null;

    #[ORM\Column(nullable: true)]
    private ?int $celular = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $f_nacimiento = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $f_ingreso = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $f_examen_ingreso = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Sexo $sexo = null;

    #[ORM\ManyToOne(inversedBy: 'personals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TipoNomina $tipo_nomina = null;

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
    #[ORM\JoinColumn(nullable: false)]
    private ?TallaUniforme $talla_uniforme = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?TallaBotas $talla_botas = null;

    #[ORM\ManyToOne(inversedBy: 'personals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cargo $cargo = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?TallaGuantes $talla_guantes = null;

    #[ORM\ManyToOne(inversedBy: 'personals')]
    private ?CursoEspecializado $curso_especializado = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?TallaCamisa $talla_camisa = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?TallaPantalon $talla_pantalon = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?TallaCalzado $talla_calzado = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'personal', targetEntity: Contrato::class)]
    private Collection $contratos;

    #[ORM\OneToMany(mappedBy: 'personal', targetEntity: ContratoPersonal::class)]
    private Collection $contratoPersonals;

    public function __construct()
    {
        $this->contratos = new ArrayCollection();
        $this->contratoPersonals = new ArrayCollection();
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
        $this->bono = $bono;

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

    public function getTelefono(): ?int
    {
        return $this->telefono;
    }

    public function setTelefono(?int $telefono): self
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

    public function getCelular(): ?int
    {
        return $this->celular;
    }

    public function setCelular(?int $celular): self
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

    public function getTipoNomina(): ?TipoNomina
    {
        return $this->tipo_nomina;
    }

    public function setTipoNomina(?TipoNomina $tipo_nomina): self
    {
        $this->tipo_nomina = $tipo_nomina;

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
}
