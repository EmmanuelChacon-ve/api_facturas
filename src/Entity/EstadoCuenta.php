<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\EstadoCuentaRepository;
use Doctrine\DBAL\Types\Types;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Post;

use ApiPlatform\Metadata\GetCollection;
use App\Controller\EstadoCuentaController;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Event\PreUpdateEventArgs;



#[ORM\Entity(repositoryClass: EstadoCuentaRepository::class)]
#[ORM\HasLifecycleCallbacks] 
#[ApiResource(
    normalizationContext: [ 
        'groups' => ['item:estad:read']
    ],
    denormalizationContext: [
        'groups' => ['item:estado:write']
    ],
    operations: [
        new Get(
            name: 'calcular_saldo', 
            uriTemplate: '/estado_cuenta/{id}/calcular',
            controller: EstadoCuentaController::class,
            read: false,
            output: false,
        ),
        new GetCollection(),
        new Put(
            denormalizationContext: ['groups' => ['item:estado:write']],
        ),
        new Delete(
            denormalizationContext: ['groups' => ['item:estado:write']],
        ),
        new Post(
            denormalizationContext: ['groups' => ['item:estado:write']],
            normalizationContext: [ 
                'groups' => ['item:estado:read']
            ],
        ),
    ]
)]
#[ApiFilter(SearchFilter::class, properties: ['factura' => 'partial'])]
class EstadoCuenta
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
       #[Groups(["item:estado:read", "item:estado:write"])]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: '0')]
       #[Groups(["item:estado:read", "item:estado:write"])]
    private ?string $saldo_actual = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: '0')]
       #[Groups(["item:estado:read", "item:estado:write"])]
    private ?string $monto_pagado = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: '0')]
       #[Groups(["item:estado:read", "item:estado:write"])]
    private ?string $monto_pendiente = null;

    #[ORM\Column(nullable: true)]
       #[Groups(["item:estado:read", "item:estado:write"])]
    private ?\DateTimeImmutable $createAt = null;

    #[ORM\Column(nullable: true)]
       #[Groups(["item:estado:read", "item:estado:write"])]
    private ?\DateTimeImmutable $updateAt = null;

    #[ORM\Column(nullable: true)]

    private ?\DateTimeImmutable $deleteAt = null;

    #[ORM\ManyToOne(inversedBy: 'estadosCuenta')]
       #[Groups(["item:estado:read", "item:estado:write"])]
    private ?Factura $factura = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSaldoActual(): ?string
    {
        return $this->saldo_actual;
    }

    public function setSaldoActual(string $saldo_actual): static
    {
        $this->saldo_actual = $saldo_actual;

        return $this;
    }

    public function getMontoPagado(): ?string
    {
        return $this->monto_pagado;
    }

    public function setMontoPagado(string $monto_pagado): static
    {
        $this->monto_pagado = $monto_pagado;

        return $this;
    }

    public function getMontoPendiente(): ?string
    {
        return $this->monto_pendiente;
    }

    public function setMontoPendiente(string $monto_pendiente): static
    {
        $this->monto_pendiente = $monto_pendiente;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeImmutable
    {
        return $this->createAt;
    }

    public function setCreateAt(?\DateTimeImmutable $createAt): static
    {
        $this->createAt = $createAt;

        return $this;
    }

  /*   #[ORM\PrePersist]
    public function setCreatedAtValue(): static
    {
        $this->createAt = new \DateTimeImmutable();

        return $this;
    } */

    public function getUpdateAt(): ?\DateTimeImmutable
    {
        return $this->updateAt;
    }

    public function setUpdateAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updateAt = $updatedAt;

        return $this;
    }

/*     #[ORM\PreUpdate]
    public function setUpdateAtValue(PreUpdateEventArgs $eventArgs): self
    {
        $this->updateAt = new \DateTimeImmutable();

        return $this;
    } */



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
