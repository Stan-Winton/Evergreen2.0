<?php

namespace App\Entity;

use App\Repository\ProductosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductosRepository::class)]
class Productos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $nombre = null;

    #[ORM\Column]
    private ?int $precio = null;

    #[ORM\Column(length: 255)]
    private ?string $descripcion = null;

    #[ORM\Column]
    private ?int $stock = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $tipo_producto = null;

    #[ORM\ManyToOne(inversedBy: 'productos')]
    private ?Comercios $comercios = null;

    #[ORM\ManyToMany(targetEntity: Pedidos::class, inversedBy: 'productos')]
    private Collection $pedido;

    #[ORM\OneToMany(targetEntity: Valoraciones::class, mappedBy: 'productos')]
    private Collection $valoracion;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $imagen = null;

    public function __construct()
    {
        $this->pedido = new ArrayCollection();
        $this->valoracion = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPrecio(): ?int
    {
        return $this->precio;
    }

    public function setPrecio(int $precio): static
    {
        $this->precio = $precio;

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

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): static
    {
        $this->stock = $stock;

        return $this;
    }

    public function getTipoProducto(): ?string
    {
        return $this->tipo_producto;
    }

    public function setTipoProducto(?string $tipo_producto): self
    {
        $this->tipo_producto = $tipo_producto;

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
        }

        return $this;
    }

    public function removePedido(Pedidos $pedido): static
    {
        $this->pedido->removeElement($pedido);

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
            $valoracion->setProductos($this);
        }

        return $this;
    }

    public function removeValoracion(Valoraciones $valoracion): static
    {
        if ($this->valoracion->removeElement($valoracion)) {
            // set the owning side to null (unless already changed)
            if ($valoracion->getProductos() === $this) {
                $valoracion->setProductos(null);
            }
        }

        return $this;
    }

    public function getImagen(): ?string
    {
        return $this->imagen;
    }

    public function setImagen(?string $imagen): static
    {
        $this->imagen = $imagen;

        return $this;
    }
}
