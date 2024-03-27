<?php

namespace App\Entity;

use App\Repository\UsuarioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UsuarioRepository::class)]
class Usuario implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 20)]
    private ?string $nombre = null;

    #[ORM\Column(length: 100)]
    private ?string $direccion = null;

    #[ORM\Column(length: 9)]
    private ?string $telefono = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fecha = null;

    #[ORM\ManyToOne(inversedBy: 'usuario')]
    private ?Comercios $comercios = null;

    #[ORM\OneToMany(targetEntity: Pedidos::class, mappedBy: 'usuario')]
    private Collection $pedido;

    #[ORM\OneToMany(targetEntity: Valoraciones::class, mappedBy: 'usuario')]
    private Collection $valoracion;

    public function __construct($id = null, $email = null, $password = null, $nombre = null, $direccion = null, $telefono = null, $fecha = null, $comercios = null, $pedido = null, $valoracion = null)
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->nombre = $nombre;
        $this->direccion = $direccion;
        $this->telefono = $telefono;
        $this->fecha = $fecha;
        $this->comercios = $comercios;
        $this->pedido = new ArrayCollection();
        $this->valoracion = new ArrayCollection();  
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(string $direccion): static
    {
        $this->direccion = $direccion;

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

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): static
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getComercios(): ?Comercios
    {
        return $this->comercios;
    }

    public function setComercios(?Comercios $comercios): static
    {
        $this->comercios = $comercios;

        return $this;
    }

    /**
     * @return Collection<int, pedidos>
     */
    public function getPedido(): Collection
    {
        return $this->pedido;
    }

    public function addPedido(Pedidos $pedido): static
    {
        if (!$this->pedido->contains($pedido)) {
            $this->pedido->add($pedido);
            $pedido->setUsuario($this);
        }

        return $this;
    }

    public function removePedido(Pedidos $pedido): static
    {
        if ($this->pedido->removeElement($pedido)) {
            // set the owning side to null (unless already changed)
            if ($pedido->getUsuario() === $this) {
                $pedido->setUsuario(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, valoraciones>
     */
    public function getValoracion(): Collection
    {
        return $this->valoracion;
    }

    public function addValoracion(Valoraciones $valoracion): static
    {
        if (!$this->valoracion->contains($valoracion)) {
            $this->valoracion->add($valoracion);
            $valoracion->setUsuario($this);
        }

        return $this;
    }

    public function removeValoracion(Valoraciones $valoracion): static
    {
        if ($this->valoracion->removeElement($valoracion)) {
            // set the owning side to null (unless already changed)
            if ($valoracion->getUsuario() === $this) {
                $valoracion->setUsuario(null);
            }
        }

        return $this;
    }
}
