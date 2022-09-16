<?php

namespace App\Tests\Entity;

use App\Exception\EmailInvalid;
use App\Entity\Person;
use App\Entity\ValueObject\CpfCnpj;
use App\Entity\ValueObject\Name;
use App\Entity\ValueObject\Phone;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PersonTest extends KernelTestCase
{
    public function testCreatePessonSucess(): void
    {
        $person = new Person(
            name: new Name("Vicente de Paulo"),
            phone: new Phone("85986690541"),
            email: "vpp.filho@gmail.com",
            cpfCnpj: new CpfCnpj('01475171331')
        );

        $this->assertEquals($person->getEmail(), 'vpp.filho@gmail.com');
        $this->assertEquals($person->getName(), 'Vicente de Paulo');
        $this->assertEquals($person->getCpfCnpj(), '01475171331');
    }

    public function testCreatePessonError(): void
    {
        $this->expectException(EmailInvalid::class);

        $person = new Person(
            name: new Name("Vicente de Paulo"),
            phone: new Phone("85986690541"),
            email: "vpp.filho",
            cpfCnpj: new CpfCnpj('01475171331')
        );
    }
}
