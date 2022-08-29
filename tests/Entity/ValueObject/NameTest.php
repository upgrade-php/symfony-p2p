<?php

namespace App\Tests\Entity\ValueObject;

use PHPUnit\Framework\TestCase;
use App\Entity\ValueObject\Name;
use ErrorException;

class NameTest extends TestCase
{
    public function testCreateFullNameSucess(): void
    {
        $name = new Name("Vicente de Paulo Pinheiro Filho");
        $this->assertEquals($name->getFirstName(), "Vicente de Paulo");
        $this->assertEquals($name->getLastName(), "Pinheiro Filho");
    }

    public function testCreateFullNameWithTreeNames(): void
    {
        $name = new Name("Antonio Cesar Pinheiro");
        $this->assertEquals($name->getFirstName(), "Antonio Cesar");
        $this->assertEquals($name->getLastName(), "Pinheiro");
    }

    public function testCreateFullNameWithTwoNames(): void
    {
        $name = new Name("Luciano Pinheiro");
        $this->assertEquals($name->getFirstName(), "Luciano");
        $this->assertEquals($name->getLastName(), "Pinheiro");
    }

    public function testCreateFullNameWithOneName(): void
    {
        $name = new Name("Luciano");
        $this->assertEquals($name->getFirstName(), "Luciano");
        $this->assertEquals($name->getLastName(), null);
    }

    public function testCreateFullNameWithError(): void
    {
        $this->expectException(ErrorException::class);
        $name = new Name("Luciano1");
    }
}
