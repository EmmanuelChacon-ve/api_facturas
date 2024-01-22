<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PagoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Put;
use Doctrine\ORM\Event\PreUpdateEventArgs;

#[ORM\Entity(repositoryClass: PagoRepository::class)]
#[ORM\HasLifecycleCallbacks] 
#[ApiResource(
    operations: [
        new Get(
            normalizationContext: [ 
                'groups' => ['item:pago:read']
            ]
        ),
        new Put(denormalizationContext: [
            'groups' => ['item:pago:write']
        ],),
        new GetCollection(),
        new Delete(
            denormalizationContext: ['groups' => ['item:pago:write']],
        ),
        new Post(  denormalizationContext: ['groups' => ['item:pago:write']],),
    ]
)]
#[ApiFilter(SearchFilter::class, properties: ['metodo_pago' => 'partial'])]
class Pago
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["item:pago:read", "item:pago:write"])]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: '0')]
    #[Groups(["item:pago:read", "item:pago:write"])]
    private ?string $monto = null;

    #[ORM\Column(length: 255)]
    #[Groups(["item:pago:read", "item:pago:write"])]
    private ?string $metodo_pago = null;

    #[ORM\Column]
    #[Groups(["item:pago:read", "item:pago:write"])]
    private ?\DateTimeImmutable $createAt = null;

    #[ORM\Column]
    #[Groups(["item:pago:read", "item:pago:write"])]
    private ?\DateTimeImmutable $updateAt = null;

    #[ORM\Column(nullable: true)]
   
    private ?\DateTimeImmutable $deleteAt = null;

    #[ORM\ManyToOne(inversedBy: 'pagos')]
        #[Groups(["item:pago:read", "item:pago:write"])]
    private ?Factura $factura = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMonto(): ?string
    {
        return $this->monto;
    }

    public function setMonto(string $monto): static
    {
        $this->monto = $monto;

        return $this;
    }

    public function getMetodoPago(): ?string
    {
        return $this->metodo_pago;
    }

    public function setMetodoPago(string $metodo_pago): static
    {
        $this->metodo_pago = $metodo_pago;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeImmutable
    {
        return $this->createAt;
    }
    #[ORM\PrePersist] 
    public function setCreateAt(\DateTimeImmutable $createAt): static
    {
        $this->createAt = $createAt;

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
}
