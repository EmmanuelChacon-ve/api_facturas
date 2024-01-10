<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\FacturaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: FacturaRepository::class)]
#[ApiResource(
    normalizationContext: [
        'groups' => ['read']
    ],
    denormalizationContext: [
        'groups' => ['write']
    ]
)]
#[ApiFilter(SearchFilter::class, properties: ['cliente.name' => 'partial'])]
#[ApiFilter(OrderFilter::class, properties: ['numfactura' => 'desc'])]
class Factura
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["read"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["read", "write"])]
    private ?string $numfactura = null;

    #[ORM\Column]
    #[Groups(['read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups(['write'])]
    private ?\DateTimeImmutable $updateAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['write'])]
    private ?\DateTimeImmutable $deleteAt = null;

    #[ORM\ManyToOne(inversedBy: 'facturas')]
    #[Groups(['write'])]
    private ?Cliente $cliente = null;

    #[ORM\OneToMany(mappedBy: 'factura', targetEntity: LineaFactura::class)]
    #[Groups(['write'])]
    private Collection $lineasfacturas;

    #[ORM\OneToMany(mappedBy: 'factura', targetEntity: Pago::class)]
    #[Groups(['write'])]
    private Collection $pagos;

    #[ORM\OneToMany(mappedBy: 'factura', targetEntity: EstadoCuenta::class)]
    #[Groups(['write'])]
    private Collection $estadosCuenta;

    public function __construct()
    {
        $this->lineasfacturas = new ArrayCollection();
        $this->pagos = new ArrayCollection();
        $this->estadosCuenta = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumfactura(): ?string
    {
        return $this->numfactura;
    }

    public function setNumfactura(string $numfactura): static
    {
        $this->numfactura = $numfactura;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

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

    public function getCliente(): ?Cliente
    {
        return $this->cliente;
    }

    public function setCliente(?Cliente $cliente): static
    {
        $this->cliente = $cliente;

        return $this;
    }

    /**
     * @return Collection<int, LineaFactura>
     */
    public function getLineasfacturas(): Collection
    {
        return $this->lineasfacturas;
    }

    public function addLineasfactura(LineaFactura $lineasfactura): static
    {
        if (!$this->lineasfacturas->contains($lineasfactura)) {
            $this->lineasfacturas->add($lineasfactura);
            $lineasfactura->setFactura($this);
        }

        return $this;
    }

    public function removeLineasfactura(LineaFactura $lineasfactura): static
    {
        if ($this->lineasfacturas->removeElement($lineasfactura)) {
            // set the owning side to null (unless already changed)
            if ($lineasfactura->getFactura() === $this) {
                $lineasfactura->setFactura(null);
            }
        }

        return $this;
    }

  /*   public function getClienteFactura(): ?Cliente
    {
        return $this->cliente_factura;
    }

    public function setClienteFactura(?Cliente $cliente_factura): static
    {
        $this->cliente_factura = $cliente_factura;

        return $this;
    } */

    /**
     * @return Collection<int, Pago>
     */
    public function getPagos(): Collection
    {
        return $this->pagos;
    }

    public function addPago(Pago $pago): static
    {
        if (!$this->pagos->contains($pago)) {
            $this->pagos->add($pago);
            $pago->setFactura($this);
        }

        return $this;
    }

    public function removePago(Pago $pago): static
    {
        if ($this->pagos->removeElement($pago)) {
            // set the owning side to null (unless already changed)
            if ($pago->getFactura() === $this) {
                $pago->setFactura(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, EstadoCuenta>
     */
    public function getEstadosCuenta(): Collection
    {
        return $this->estadosCuenta;
    }

    public function addEstadosCuentum(EstadoCuenta $estadosCuentum): static
    {
        if (!$this->estadosCuenta->contains($estadosCuentum)) {
            $this->estadosCuenta->add($estadosCuentum);
            $estadosCuentum->setFactura($this);
        }

        return $this;
    }

    public function removeEstadosCuentum(EstadoCuenta $estadosCuentum): static
    {
        if ($this->estadosCuenta->removeElement($estadosCuentum)) {
            // set the owning side to null (unless already changed)
            if ($estadosCuentum->getFactura() === $this) {
                $estadosCuentum->setFactura(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, EstadoCuenta>
     */


/*     public function addEstadoCuenta(EstadoCuenta $estadoCuenta): static
    {
        if (!$this->estadoCuentas->contains($estadoCuenta)) {
            $this->estadoCuentas->add($estadoCuenta);
            $estadoCuenta->setFacturas($this);
        }

        return $this;
    }

    public function removeEstadoCuenta(EstadoCuenta $estadoCuenta): static
    {
        if ($this->estadoCuentas->removeElement($estadoCuenta)) {
            // set the owning side to null (unless already changed)
            if ($estadoCuenta->getFacturas() === $this) {
                $estadoCuenta->setFacturas(null);
            }
        }

        return $this;
    } */
}
