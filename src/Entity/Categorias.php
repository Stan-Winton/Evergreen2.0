<?php

namespace App\Entity;

use App\Repository\CategoriasRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoriasRepository::class)]
class Categorias
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $nombre = null;

    #[ORM\Column(length: 20)]
    private ?string $tipo = null;

    #[ORM\OneToOne(mappedBy: 'categoria', cascade: ['persist', 'remove'])]
    private ?Productos $productos = null;

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

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): static
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getProductos(): ?Productos
    {
        return $this->productos;
    }

    public function setProductos(?Productos $productos): static
    {
        // unset the owning side of the relation if necessary
        if ($productos === null && $this->productos !== null) {
            $this->productos->setCategoria(null);
        }

        // set the owning side of the relation if necessary
        if ($productos !== null && $productos->getCategoria() !== $this) {
            $productos->setCategoria($this);
        }

        $this->productos = $productos;

        return $this;
    }
}
