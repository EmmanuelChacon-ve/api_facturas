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



#[ORM\Entity(repositoryClass: EstadoCuentaRepository::class)]
#[ApiResource(
    normalizationContext: [ 
        'groups' => ['item:read']
    ],
    denormalizationContext: [
        'groups' => ['write']
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
            denormalizationContext: ['groups' => ['item:write']],
        ),
        new Delete(
            denormalizationContext: ['groups' => ['item:write']],
        ),
        new Post(
            denormalizationContext: ['groups' => ['item:write']],
        ),
    ]
)]
#[ApiFilter(SearchFilter::class, properties: ['factura' => 'partial'])]
class EstadoCuenta
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
       #[Groups(["item:read", "item:write"])]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: '0')]
       #[Groups(["item:read", "item:write"])]
    private ?string $saldo_actual = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: '0')]
       #[Groups(["item:read", "item:write"])]
    private ?string $monto_pagado = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: '0')]
       #[Groups(["item:read", "item:write"])]
    private ?string $monto_pendiente = null;

    #[ORM\Column]
       #[Groups(["item:read", "item:write"])]
    private ?\DateTimeImmutable $createAt = null;

    #[ORM\Column]
       #[Groups(["item:read", "item:write"])]
    private ?\DateTimeImmutable $updateAt = null;

    #[ORM\Column(nullable: true)]

    private ?\DateTimeImmutable $deleteAt = null;

    #[ORM\ManyToOne(inversedBy: 'estadosCuenta')]
       #[Groups(["item:read", "item:write"])]
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
