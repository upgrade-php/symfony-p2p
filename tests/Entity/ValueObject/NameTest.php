<?php

namespace App\Tests\Entity\ValueObject;

use PHPUnit\Framework\TestCase;
use App\Entity\ValueObject\Name;
use ErrorException;

class NameTest extends TestCase
{
    public function getNames(){
        return [
            ["Ian Assunção", "Ian", "Assunção"],
            ["Vicente de Paulo Pinheiro Filho", "Vicente de Paulo", "Pinheiro Filho"],
            ["Márcion Ferreira Matos", "Márcion", "Matos"],           
        ];
    }

    /**
     * @dataProvider getNames
     */

    public function testCreateFullNameSucess($name, $fistName, $lastName): void
    {
        $n = new Name($name);
        $this->assertEquals($n->getFirstName(), $fistName);
        $this->assertEquals($n->getLastName(), $lastName);
    }

    public function testCreateFullNameWithTreeNames(): void
    {
        $name = new Name("Antonio Cesar Pinheiro");
        $this->assertEquals($name->getFirstName(), "Antonio");
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
