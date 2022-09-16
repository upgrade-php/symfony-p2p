<?php

namespace App\Entity\ValueObject;

use ErrorException;
use Doctrine\ORM\Mapping as ORM;

#[Orm\Embeddable]
class Name {

    #[ORM\Column(length: 255)]
    private $name;
    
    private $firstName;
    
    private $lastName;

    public function __construct(string $fullName)
    {
        $this->setName($fullName);
    }

    private function setName(string $name){
        
        if (!preg_match ("/^([a-zA-Z' ]+)$/", $this->removeAccents($name)) )
        {
            throw new ErrorException("Name not valid: {$name}");
        }

        $this->name = $name;
        $arrayNames = explode(" ", $name);

        if(count($arrayNames)==1){
            $this->firstName = $name;
            return;
        }

        $names = array_chunk($arrayNames, 3);

        if(count($names)==1){
            $this->firstName = $names[0][0];
            $this->lastName = $names[0][count($names[0])-1];
        }
        elseif(count($names)==2){
            $this->firstName = implode(' ', $names[0]);
            $this->lastName = implode(' ', $names[1]);
        }   
    }

    private function removeAccents($name){
        $search = explode(",","ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,e,i,ø,u,ã");
        $replace = explode(",","c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,e,i,o,u,a");
        return str_replace($search, $replace, $name);
    }

    public function getName(){
        return $this->name;
    }

    public function getFirstName(){
        return $this->firstName;
    }

    public function getLastName(){
        return $this->lastName;
    }

    public function __toString()
    {
        return $this->name;
    }
}