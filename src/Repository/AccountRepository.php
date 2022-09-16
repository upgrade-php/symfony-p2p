<?php

namespace App\Repository;

use App\Entity\Account;
use App\Entity\Person;
use App\Entity\ValueObject\CpfCnpj;
use App\Entity\ValueObject\Name;
use App\Entity\ValueObject\Phone;
use App\Exception\PersonInvalid;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AccountRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Account::class);
    }


    public function create(string $name, string $email, string $phone, string $cpfCnpj)
    {
        $cpfCnpjClened = new CpfCnpj($cpfCnpj);
        $person = new Person(name: new Name($name), email: $email, phone: new Phone($phone), cpfCnpj: $cpfCnpjClened);
        $person->setCreatedAt(new \DateTimeImmutable('now'));
        $rs1 = $this->getEntityManager()->getRepository(Person::class)->findAll();

        $has_person = $this->getEntityManager()->getRepository(Person::class)->findOneBy(['cpfCnpj.cpfCnpj' => (string) $cpfCnpjClened]);

        if($has_person){
            throw new PersonInvalid("cpf or cnpj already exists");
        }

        $account = new Account(person: $person);
        $account->setCreatedAt(new \DateTimeImmutable('now'));
        $account->setAccountNumber($this->generationAccountNumber($person));
        $account->setStatus(Account::STATUS_PENDING);
        $this->add($account, true);
        return $account;
    }

    private function generationAccountNumber(Person $person)
    {
        $lastAccountInserted = $this->lastInserted();
        $number = $lastAccountInserted ? $lastAccountInserted->getId() + 1 : 1;

        $numbers = [];
        if ($person->getCpfCnpj()->isCpf()) {
            $numbers[] = (int) substr($person->getCpfCnpj(), 6, 1);
        } else {
            $numbers[] = (int) substr($person->getCpfCnpj(), 3, 1);
        }

        $numbers[] = (int) date('y');
        $numbers[] = (int) rand(0, 9);
        $numbers[] = (int) $number;
        $digito = array_reduce($numbers, fn ($ac, $x) => $ac + $x);
        while (strlen((string) $digito) > 1) {
            $digito = array_reduce(str_split((string) $digito), fn ($ac, $x) => $ac + $x);
        }
        $numbers[] = $digito;
        $numbers[3] = str_pad($number, 4, '0', STR_PAD_LEFT);

        return '' . join($numbers);
    }

    public function add(Account $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Account $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function lastInserted()
    {
        $qb = $this->createQueryBuilder('a')
            ->orderBy('a.createdAt', 'DESC')
            ->setMaxResults(1);
        $query = $qb->getQuery();

        return $query->getOneOrNullResult();
    }
}
