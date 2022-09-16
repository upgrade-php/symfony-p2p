<?php

namespace App\Tests\Base;

use PHPUnit\Framework\TestCase;
use App\Tests\Base\FakerFactory;

class MyTestCase extends TestCase
{

    public function createSeed($className)
    {
        $faker = FakerFactory::create();
        $obj = new $className();
        return $obj->maker($faker);
    }
}