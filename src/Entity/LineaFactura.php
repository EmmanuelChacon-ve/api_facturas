<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\LineaFacturaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Put;
use App\Controller\VentaStatsController;
use App\Controller\StockController;
use Doctrine\ORM\Event\PreUpdateEventArgs;

#[ORM\Entity(repositoryClass: LineaFacturaRepository::class)]
#[ORM\HasLifecycleCallbacks] 
#[ApiResource(
    operations: [
        new Get(
            name: 'venta_stats', 
            uriTemplate: '/linea_facturas/venta/stats',
            controller: VentaStatsController::class,
            read: false,
            output: false,
            normalizationContext: [
                'groups' => ['item:lfactura:read']
            ]
        ),
        new Get(
            name: 'stock', 
            uriTemplate: '/linea_facturas/stock/calculate',
            controller: StockController::class,
            read: false,
            output: false,
            normalizationContext: [
                'groups' => ['item:lfactura:read']
            ]
        ),
        new Put(denormalizationContext: [
            'groups' => ['item:lfactura:write']
        ],),
        new GetCollection(
            normalizationContext: [
                'groups' => ['item:lfactura:read']
            ]
        ),
        new Delete(
            denormalizationContext: ['groups' => ['item:lfactura:write']],
        ),
        new Post(  denormalizationContext: ['groups' => ['item:lfactura:write']],),
    ]

)]
class LineaFactura
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["item:lfactura:read", "item:lfactura:write"])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(["item:lfactura:read", "item:lfactura:write"])]
    private ?int $cantidad = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: '0')]
    #[Groups(["item:lfactura:read", "item:lfactura:write"])]
    private ?string $precio_unitario = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: '0')]
    #[Groups(["item:lfactura:read", "item:lfactura:write"])]
    private ?string $subtotal = null;

    #[ORM\Column]
    #[Groups(["item:lfactura:read", "item:lfactura:write"])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups(["item:lfactura:read", "item:lfactura:write"])]
    private ?\DateTimeImmutable $updateAt = null;

    #[ORM\Column(nullable: true)]
 
    private ?\DateTimeImmutable $deleteAt = null;

    #[ORM\ManyToOne(inversedBy: 'lineasfacturas')]
    #[Groups(["item:lfactura:read", "item:lfactura:write"])]
    
    private ?Factura $factura = null;

    #[ORM\ManyToOne(inversedBy: 'lineasFactura')]
    #[Groups(["item:lfactura:read", "item:lfactura:write"])]
    private ?Producto $producto = null;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCantidad(): ?int
    {
        return $this->cantidad;
    }

    public function setCantidad(int $cantidad): static
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    public function getPrecioUnitario(): ?string
    {
        return $this->precio_unitario;
    }

    public function setPrecioUnitario(string $precio_unitario): static
    {
        $this->precio_unitario = $precio_unitario;

        return $this;
    }

    public function getSubtotal(): ?string
    {
        return $this->subtotal;
    }

    public function setSubtotal(string $subtotal): static
    {
        $this->subtotal = $subtotal;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }
    #[ORM\PrePersist]
    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeImmutable
    {
        return $this->updateAt;
    }
 
    #[ORM\PreUpdate]

    public function setUpdateAt(PreUpdateEventArgs $eventArgs): void
    {
        $this->updateAt = new \DateTimeImmutable();
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

    public function getFactura(): ?Factura
    {
        return $this->factura;
    }

    public function setFactura(?Factura $factura): static
    {
        $this->factura = $factura;

        return $this;
    }

    public function getProducto(): ?Producto
    {
        return $this->producto;
    }

    public function setProducto(?Producto $producto): static
    {
        $this->producto = $producto;

        return $this;
    }


}
