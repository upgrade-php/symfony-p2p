<?php

namespace App\Tests\Entity\ValueObject;

use App\Entity\ValueObject\Phone;
use ErrorException;
use PHPUnit\Framework\TestCase;

class PhoneTest extends TestCase
{
    public function testCreatePhoneNumberSucess(): void
    {
        $phone = new Phone('(85) 98669-0541');
        $this->assertEquals($phone->getPhone(), '85986690541');
    }

    public function testCreatePhoneNumberOnlyNumberSucess(): void
    {
        $phone = new Phone('85986690541');
        $this->assertEquals($phone->getPhone(), '85986690541');
    }


    public function testCreatePhoneNumberError(): void
    {
        $this->expectException(ErrorException::class);
        new Phone('986690541');
    }
}
