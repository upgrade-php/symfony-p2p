<?php

namespace App\Tests\Entity;

use App\Entity\Account;
use App\Tests\Base\MyTestCase;
use App\Tests\DataFixtures\PersonFixture;

class AccoutTest extends MyTestCase
{
    public function testCreateAccount(): void
    {
        $person = $this->createSeed(PersonFixture::class);

        $account = new Account(person: $person);
        $this->assertEquals($account->getPerson()->getName(), $person->getName());
    }
}
