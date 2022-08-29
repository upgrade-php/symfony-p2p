<?php

namespace App\Entity\ValueObject;

use ErrorException;
use Twig\TokenParser\ImportTokenParser;

class Name {

    private $fullName;
    private $firstName;
    private $lastName;

    public function __construct(string $fullName)
    {
        $this->setName($fullName);
    }

    private function setName(string $name){
        
        if (!preg_match ("/^([a-zA-Z' ]+)$/", $name) )
        {
            throw new ErrorException("Name not valid");
        }

        $this->fullName = $name;
        $arrayNames = explode(" ", $name);
        if(count($arrayNames)==1){
            $this->firstName = $name;
            return;
        }

        $names = array_chunk($arrayNames, 2);

        if(count($names)==1){
            $this->firstName = $names[0][0];
            $this->lastName = $names[0][1];
        }
        elseif(count($names)==2){
            $this->firstName = implode(' ', $names[0]);
            $this->lastName = implode(' ', $names[1]);
        }elseif(count($names)>2){
            $this->firstName = implode(' ', $names[0]);
            if(str_contains($names[0][1], 'de') || str_contains($names[0][1], 'da')){
                $this->firstName .= " ".$names[1][0];
                $this->lastName .= $names[1][1];
                array_shift($names);
            }
            array_shift($names);
            foreach($names as $l){
                $this->lastName .= " ".implode(' ', $l);
            }
            
        }        
    }

    public function getFullName(){
        return $this->fullName;
    }

    public function getFirstName(){
        return $this->firstName;
    }

    public function getLastName(){
        return $this->lastName;
    }
}