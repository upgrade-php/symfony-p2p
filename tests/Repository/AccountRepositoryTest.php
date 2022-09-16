<?php

namespace App\Tests\Repository;

use App\Exception\PersonInvalid;
use App\Repository\AccountRepository;
use App\Tests\Base\DatabasePrimer;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Tests\Base\FakerFactory;


class AccountRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;
    private $container;
    private $faker;


    protected function setUp(): void
    {
        self::bootKernel();
        DatabasePrimer::prime(self::$kernel);
        $this->container = static::getContainer();
        $this->entityManager = $this->container->get('doctrine')->getManager();
        $this->faker = FakerFactory::create();
    }


    public function testRegisterAccountSucess(): void
    {
        $accountRepository = $this->container->get(AccountRepository::class);
        $cpf = $this->faker->cpf();
        $rs = $accountRepository->create(
            name: "Vicente de Paulo", 
            email: $this->faker->email(), 
            phone: "85986690541",
            cpfCnpj: $cpf
        );

       $cpf = preg_replace('/\D+/', '', trim($cpf));
       $this->assertEquals((string) $rs->getPerson()->getCpfCnpj(), $cpf);
    }


    public function testRegisterAccountError(): void
    {
        $this->expectException(PersonInvalid::class);
        $accountRepository = $this->container->get(AccountRepository::class);
        $cpf = $this->faker->cpf();
        $r1 = $accountRepository->create(
            name: "Vicente de Paulo", 
            email: $this->faker->email(), 
            phone: "85986690541",
            cpfCnpj: $cpf
        );

        $r2 = $accountRepository->create(
            name: "Vicente de Paulo", 
            email: $this->faker->email(), 
            phone: "85986690541",
            cpfCnpj: $cpf
        );


    }


    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null;
    }
}
