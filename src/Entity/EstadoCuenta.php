<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\EstadoCuentaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EstadoCuentaRepository::class)]
#[ApiResource]
class EstadoCuenta
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: '0')]
    private ?string $saldo_actual = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: '0')]
    private ?string $monto_pagado = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: '0')]
    private ?string $monto_pendiente = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updateAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deleteAt = null;

    #[ORM\ManyToOne(inversedBy: 'estadosCuenta')]
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
