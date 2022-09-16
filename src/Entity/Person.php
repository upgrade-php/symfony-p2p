<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Exception\EmailInvalid;
use App\Entity\ValueObject\CpfCnpj;
use App\Entity\ValueObject\Name;
use App\Entity\ValueObject\Phone;
use App\Repository\PersonRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Person
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Embedded(Name::class)]
    private Name $name;

    #[ORM\Column(length: 255)]
    private string $email;

    #[ORM\Embedded(Phone::class)]
    private Phone $phone;

    #[ORM\Embedded(CpfCnpj::class)]
    private CpfCnpj $cpfCnpj;

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(nullable:true)]
    private \DateTimeImmutable $updatedAt;

    public function __construct(Name $name, string $email, Phone $phone, CpfCnpj $cpfCnpj)
    {
        $this->name = $name;
        $this->setEmail($email);
        $this->phone = $phone;
        $this->cpfCnpj = $cpfCnpj;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            throw new EmailInvalid("Email is not valid");
        }

        $this->email = $email;

        return $this;
    }

    public function getPhone(): Phone
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getCpfCnpj(): CpfCnpj
    {
        return $this->cpfCnpj;
    }

    public function setCpfCnpj(string $cpfcnpj): self
    {
        $this->cpfCnpj = $cpfcnpj;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
