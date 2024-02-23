<?php

namespace App\Entity;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\LogRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LogRepository::class)]
#[ApiResource]
class Log
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Level = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $message = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $requestUrl = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $requestMethod = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $requestParams = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $responseCode = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'logs')]
    private ?pago $log_pago = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLevel(): ?string
    {
        return $this->Level;
    }

    public function setLevel(?string $Level): static
    {
        $this->Level = $Level;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function getRequestUrl(): ?string
    {
        return $this->requestUrl;
    }

    public function setRequestUrl(?string $requestUrl): static
    {
        $this->requestUrl = $requestUrl;

        return $this;
    }

    public function getRequestMethod(): ?string
    {
        return $this->requestMethod;
    }

    public function setRequestMethod(?string $requestMethod): static
    {
        $this->requestMethod = $requestMethod;

        return $this;
    }

    public function getRequestParams(): ?string
    {
        return $this->requestParams;
    }

    public function setRequestParams(?string $requestParams): static
    {
        $this->requestParams = $requestParams;

        return $this;
    }

    public function getResponseCode(): ?string
    {
        return $this->responseCode;
    }

    public function setResponseCode(?string $responseCode): static
    {
        $this->responseCode = $responseCode;

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

    public function getLogPago(): ?pago
    {
        return $this->log_pago;
    }

    public function setLogPago(?pago $log_pago): static
    {
        $this->log_pago = $log_pago;

        return $this;
    }
}
