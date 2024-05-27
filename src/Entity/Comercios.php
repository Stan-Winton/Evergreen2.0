<?php

namespace App\Entity;

use App\Repository\ComerciosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: ComerciosRepository::class)]
class Comercios implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: "json")]
    private array $roles = [];

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 60)]
    private ?string $email = null;

    #[ORM\Column(length: 9)]
    private ?string $CIF = null;

    #[ORM\Column(length: 20)]
    private ?string $nombreComercio = null;

    #[ORM\Column(length: 255)]
    private ?string $descripcion = null;

    #[ORM\Column(length: 100)]
    private ?string $direccionComercio = null;

    #[ORM\Column(length: 9)]
    private ?string $telefono = null;

    #[ORM\Column(length: 30)]
    private ?string $razonSocial = null;

    #[ORM\Column(length: 5)]
    private ?string $codigoPostal = null;

    #[ORM\OneToMany(targetEntity: Usuario::class, mappedBy: 'comercios')]
    private Collection $usuario;

    #[ORM\OneToMany(targetEntity: Productos::class, mappedBy: 'comercios')]
    private Collection $productos;

    #[ORM\OneToMany(targetEntity: Pedidos::class, mappedBy: 'comercios')]
    private Collection $pedido;

    public function __construct($password= null, $email= null, $CIF= null, $nombreComercio = null, $descripcion = null, $direccionComercio = null, $telefono = null, $razonSocial = null, $codigoPostal = null)
    {
        $this->password = $password;
        $this->email = $email;
        $this->CIF = $CIF;
        $this->nombreComercio = $nombreComercio;
        $this->descripcion = $descripcion;
        $this->direccionComercio = $direccionComercio;
        $this->telefono = $telefono;
        $this->razonSocial = $razonSocial;
        $this->codigoPostal = $codigoPostal;
        $this->usuario = new ArrayCollection();
        $this->producto = new ArrayCollection();
        $this->pedido = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        if (empty($roles)) {
            $roles[] = 'ROLE_USER';
        }
        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getCIF(): ?string
    {
        return $this->CIF;
    }

    public function setCIF(string $CIF): static
    {
        $this->CIF = $CIF;

        return $this;
    }

    public function getNombreComercio(): ?string
    {
        return $this->nombreComercio;
    }

    public function setNombreComercio(string $nombreComercio): static
    {
        $this->nombreComercio = $nombreComercio;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getDireccionComercio(): ?string
    {
        return $this->direccionComercio;
    }

    public function setDireccionComercio(string $direccionComercio): static
    {
        $this->direccionComercio = $direccionComercio;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): static
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getRazonSocial(): ?string
    {
        return $this->razonSocial;
    }

    public function setRazonSocial(string $razonSocial): static
    {
        $this->razonSocial = $razonSocial;

        return $this;
    }

    
    public function getCodigoPostal(): ?string
    {
        return $this->codigoPostal;
    }

    public function setCodigoPostal(string $codigoPostal): static
    {
        $this->codigoPostal = $codigoPostal;

        return $this;
    }

    public function getUsuario(): Collection
    {
        return $this->usuario;
    }

    public function addUsuario(Usuario $usuario): static
    {
        if (!$this->usuario->contains($usuario)) {
            $this->usuario->add($usuario);
            $usuario->setComercios($this);
        }

        return $this;
    }

    public function removeUsuario(Usuario $usuario): static
    {
        if ($this->usuario->removeElement($usuario)) {
            if ($usuario->getComercios() === $this) {
                $usuario->setComercios(null);
            }
        }

        return $this;
    }

    public function getProducto(): Collection
    {
        return $this->producto;
    }

    public function addProducto(Productos $producto): static
    {
        if (!$this->producto->contains($producto)) {
            $this->producto->add($producto);
            $producto->setComercios($this);
        }

        return $this;
    }

    public function removeProducto(Productos $producto): static
    {
        if ($this->producto->removeElement($producto)) {
            if ($producto->getComercios() === $this) {
                $producto->setComercios(null);
            }
        }

        return $this;
    }

    public function getPedido(): Collection
    {
        return $this->pedido;
    }

    public function addPedido(Pedidos $pedido): static
    {
        if (!$this->pedido->contains($pedido)) {
            $this->pedido->add($pedido);
            $pedido->setComercios($this);
        }

        return $this;
    }

    public function removePedido(pedidos $pedido): static
    {
        if ($this->pedido->removeElement($pedido)) {
            if ($pedido->getComercios() === $this) {
                $pedido->setComercios(null);
            }
        }

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
    }
}