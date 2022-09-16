<?php

namespace App\Tests\Base;


use Faker\Factory as FFactory;

class FakerFactory{


    static public function create(){
        return FFactory::create('pt_BR');
    }


}