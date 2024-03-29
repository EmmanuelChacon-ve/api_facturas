<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\ClienteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use App\Controller\DeleteController;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Controller\TopClientesController;
use Doctrine\ORM\Event\PreUpdateEventArgs;


#[ORM\Entity(repositoryClass: ClienteRepository::class)]
#[ORM\HasLifecycleCallbacks] 

#[ApiResource(
  
  
    operations: [
        new Get(
            normalizationContext: [ 
                'groups' => ['item:client:read']
            ]
        ),
        new Get(
            name: 'clientesTop', 
            uriTemplate: '/clientes/top',
            controller: TopClientesController::class,
            read: false,
            output: false,
            normalizationContext: [ 
                'groups' => ['item:client:read']
            ]
        ),
        new GetCollection(
            
        ),
        new Post(
            denormalizationContext: ['groups' => ['item:client:write']],
            normalizationContext: [ 
                'groups' => ['item:read']
            ]
        ),
        new Put(
            denormalizationContext: ['groups' => ['item:client:write']],
        ),

        new Delete(
            name: 'EliminadoLogico', 
            uriTemplate: '/clientes/{id}/delete',
            controller: DeleteController::class,
            read: false,
            output: false,
            denormalizationContext: ['groups' => ['item:write']],
        ),
    ]
)]
#[ApiFilter(SearchFilter::class, properties: ['name' => 'partial'])]


/* #[Gedmo\SoftDeleteable(fieldName: 'deleteAt', timeAware: false, hardDelete: false)] */

class Cliente
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["item:read","item:client:read", "item:write", "item:client:write"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["item:read","item:client:read", "item:write", "item:client:write"])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(["item:read","item:client:read", "item:write", "item:client:write"])]
    private ?string $email = null;

    #[ORM\Column(length: 20)]
    #[Groups(["item:read","item:client:read", "item:write","item:client:write"])]
    private ?string $phone = null;

    #[ORM\Column(length: 255)]
    #[Groups(["item:read","item:client:read", "item:write","item:client:write"])]
    private ?string $address = null;

    #[ORM\OneToMany(mappedBy: 'cliente', targetEntity: Factura::class)]
    #[Groups(["item:client:read", "item:write"])]
    private Collection $facturas;



    #[ORM\Column]
    #[Groups(["item:read","item:client:read", "item:write","item:client:write"])]
    private ?\DateTimeImmutable $createAt = null;

    #[ORM\Column]
    #[Groups(["item:read","item:client:read", "item:write","item:client:write"])]
    private ?\DateTimeImmutable $updateAt = null;
 

    

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deleteAt = null;
    public function __construct()
    {
        $this->facturas = new ArrayCollection();
       
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return Collection<int, Factura>
     */
    public function getFacturas(): Collection
    {
        return $this->facturas;
    }

    public function addFactura(Factura $factura): static
    {
        if (!$this->facturas->contains($factura)) {
            $this->facturas->add($factura);
            $factura->setCliente($this);
        }

        return $this;
    }

    public function removeFactura(Factura $factura): static
    {
        if ($this->facturas->removeElement($factura)) {
            // set the owning side to null (unless already changed)
            if ($factura->getCliente() === $this) {
                $factura->setCliente(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Factura>
     */






    public function getCreateAt(): ?\DateTimeImmutable
    {
        return $this->createAt;
    }
    
    #[ORM\PrePersist]
    public function setCreateAtValue(): static
    {
        $this->createAt = new \DateTimeImmutable();

        return $this;
    }

    public function setCreateAt(?\DateTimeImmutable $createAt): static
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeImmutable
    {
        return $this->updateAt;
    }

   /*  public function setUpdateAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updateAt = $updatedAt;

        return $this;
    }
 */

#[ORM\PreUpdate]

public function setUpdateAt(?\DateTimeImmutable $updatedAt): self
{
    $this->updateAt = $updatedAt;

    return $this;
}


    /**
     * @return \DateTimeImmutable|null
     */
    public function getDeleteAt(): ?\DateTimeImmutable
    {
        return $this->deleteAt;
    }

    /**
     * @param \DateTimeImmutable|null $deleteAt
     * @return self
     */
    public function setDeleteAt(?\DateTimeImmutable $deleteAt): self
    {
        $this->deleteAt = $deleteAt;

        return $this;
    }

  
    public function delete(): void
    {
        $this->deleteAt = new \DateTimeImmutable();
    }

    public function restore(): void
    {
        $this->deleteAt = null;
    }
}