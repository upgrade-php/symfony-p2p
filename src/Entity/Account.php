<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Exception\AccountNumberInvalid;
use App\Exception\AccountStatusInvalid;
use App\Repository\AccountRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccountRepository::class)]
#[ApiResource]
class Account
{
    const STATUS_PENDING = 'pending';
    const STATUS_ACTIVE = 'active';
    const STATUS_REFUSED = 'refused';
    const STATUS_ERROR = 'error';

    const STATUS = [
        Account::STATUS_PENDING,
        Account::STATUS_ACTIVE,
        Account::STATUS_REFUSED,
        Account::STATUS_ERROR,
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10, unique: true)]
    private ?string $accountNumber = null;


    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(nullable: true)]
    private \DateTimeImmutable $updatedAt;

    #[ORM\OneToOne(targetEntity: Person::class, cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'person_id', referencedColumnName: 'id', nullable: false)]
    private Person $person;

    public function __construct(Person $person)
    {
        $this->person  = $person;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAccountNumber(): ?string
    {
        return $this->accountNumber;
    }

    public function setAccountNumber(string $accountNumber): self
    {
        if (strlen($accountNumber < 8 || !preg_match("/^\\d+$/", $accountNumber))) {
            throw new AccountNumberInvalid("Account number is not valid");
        }

        $this->accountNumber = $accountNumber;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        if(!in_array($status, Account::STATUS)){
            throw new AccountStatusInvalid("Status invalid: {$status}");
        }

        $this->status = $status;

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

    public function getPerson()
    {
        return $this->person;
    }
}
