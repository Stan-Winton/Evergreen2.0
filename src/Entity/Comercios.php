<?php

namespace App\Entity;

use App\Repository\ComerciosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ComerciosRepository::class)]
class Comercios
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $idComercio = null;

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

    #[ORM\OneToMany(targetEntity: usuario::class, mappedBy: 'comercios')]
    private Collection $usuario;

    #[ORM\OneToMany(targetEntity: productos::class, mappedBy: 'comercios')]
    private Collection $producto;

    #[ORM\OneToMany(targetEntity: pedidos::class, mappedBy: 'comercios')]
    private Collection $pedido;

    public function __construct()
    {
        $this->usuario = new ArrayCollection();
        $this->producto = new ArrayCollection();
        $this->pedido = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdComercio(): ?int
    {
        return $this->idComercio;
    }

    public function setIdComercio(int $idComercio): static
    {
        $this->idComercio = $idComercio;

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

    /**
     * @return Collection<int, usuario>
     */
    public function getUsuario(): Collection
    {
        return $this->usuario;
    }

    public function addUsuario(usuario $usuario): static
    {
        if (!$this->usuario->contains($usuario)) {
            $this->usuario->add($usuario);
            $usuario->setComercios($this);
        }

        return $this;
    }

    public function removeUsuario(usuario $usuario): static
    {
        if ($this->usuario->removeElement($usuario)) {
            // set the owning side to null (unless already changed)
            if ($usuario->getComercios() === $this) {
                $usuario->setComercios(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, productos>
     */
    public function getProducto(): Collection
    {
        return $this->producto;
    }

    public function addProducto(productos $producto): static
    {
        if (!$this->producto->contains($producto)) {
            $this->producto->add($producto);
            $producto->setComercios($this);
        }

        return $this;
    }

    public function removeProducto(productos $producto): static
    {
        if ($this->producto->removeElement($producto)) {
            // set the owning side to null (unless already changed)
            if ($producto->getComercios() === $this) {
                $producto->setComercios(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, pedidos>
     */
    public function getPedido(): Collection
    {
        return $this->pedido;
    }

    public function addPedido(pedidos $pedido): static
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
            // set the owning side to null (unless already changed)
            if ($pedido->getComercios() === $this) {
                $pedido->setComercios(null);
            }
        }

        return $this;
    }
}
