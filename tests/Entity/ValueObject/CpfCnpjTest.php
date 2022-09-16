<?php

namespace App\Tests\Entity\ValueObject;

use App\Entity\ValueObject\CpfCnpj;
use App\Exception\CpfInvalid;
use ErrorException;
use PHPUnit\Framework\TestCase;

class CpfCnpjTest extends TestCase
{
    public function testCreateCpfCnpjSucess(): void
    {
        $cc = new CpfCnpj('01475171331');

        $this->assertEquals($cc->isCpf(), true);
        $this->assertEquals($cc, '01475171331');

    }


    public function testCreateCpfCnpjError(): void
    {
        $this->expectException(CpfInvalid::class);
        new CpfCnpj('01375171331');

    }
}
