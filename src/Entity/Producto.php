<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\ProductoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Put;

#[ORM\Entity(repositoryClass: ProductoRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            normalizationContext: [ 
                'groups' => ['item:product:read']
            ]
        ),
        new Put(denormalizationContext: [
            'groups' => ['item:product:write']
        ],),
        new GetCollection(),
        new Delete(
            denormalizationContext: ['groups' => ['item:product:write']],
        ),
        new Post(  denormalizationContext: ['groups' => ['item:product:write']],),
    ]
)]

#[ApiFilter(SearchFilter::class, properties: ['name' => 'partial'])]
class Producto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["item:product:read", "item:product:write"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["item:product:read", "item:product:write"])]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(["item:product:read", "item:product:write"])]
    private ?string $description = null;


    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: '0')]
    #[Groups(["item:product:read", "item:product:write"])]
    private ?string $precio = null;

    #[ORM\Column]
    #[Groups(["item:product:read", "item:product:write"])]
    private ?\DateTimeImmutable $createAt = null;

    #[ORM\Column]
    #[Groups(["item:product:read", "item:product:write"])]
    private ?\DateTimeImmutable $updateAt = null;

    #[ORM\Column(nullable: true)]

    private ?\DateTimeImmutable $deleteAt = null;

    #[ORM\OneToMany(mappedBy: 'producto', targetEntity: LineaFactura::class)]
    #[Groups(["item:product:read", "item:product:write"])]
    private Collection $lineasFactura;


    public function __construct()
    {
        $this->lineasFactura = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrecio(): ?string
    {
        return $this->precio;
    }

    public function setPrecio(string $precio): static
    {
        $this->precio = $precio;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeImmutable
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeImmutable $createAt): static
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeImmutable
    {
        return $this->updateAt;
    }

    public function setUpdateAt(\DateTimeImmutable $updateAt): static
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    public function getDeleteAt(): ?\DateTimeImmutable
    {
        return $this->deleteAt;
    }

    public function setDeleteAt(?\DateTimeImmutable $deleteAt): static
    {
        $this->deleteAt = $deleteAt;

        return $this;
    }

    /**
     * @return Collection<int, LineaFactura>
     */
    public function getLineasFactura(): Collection
    {
        return $this->lineasFactura;
    }

    public function addLineasFactura(LineaFactura $lineasFactura): static
    {
        if (!$this->lineasFactura->contains($lineasFactura)) {
            $this->lineasFactura->add($lineasFactura);
            $lineasFactura->setProducto($this);
        }

        return $this;
    }

    public function removeLineasFactura(LineaFactura $lineasFactura): static
    {
        if ($this->lineasFactura->removeElement($lineasFactura)) {
            // set the owning side to null (unless already changed)
            if ($lineasFactura->getProducto() === $this) {
                $lineasFactura->setProducto(null);
            }
        }

        return $this;
    }

}
