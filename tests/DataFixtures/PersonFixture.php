<?php

namespace App\Tests\DataFixtures;

use App\Entity\Person;
use App\Entity\ValueObject\CpfCnpj;
use App\Entity\ValueObject\Name;
use App\Entity\ValueObject\Phone;
use App\Tests\Base\FixtureMakeInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class PersonFixture extends Fixture implements FixtureMakeInterface
{

    public function load(ObjectManager $manager): void
    {
        $manager->flush();
    }

    public function maker($faker)
    {
        return new Person(
            name: new Name($faker->firstName()." ".$faker->lastName()),
            phone: new Phone($faker->cellphoneNumber()),
            email: $faker->email(),
            cpfCnpj: new CpfCnpj($faker->cpf())
        );
    }
}
