<?php

namespace App\Entity\ValueObject;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class CpfCnpj {

    #[ORM\Column(length: 14, unique:true)]
    private $cpfCnpj;

    public function __construct(string $cpfCnpj)
    {
        $this->setCpfCnpj($cpfCnpj);
    }

    private function clear(string $data){
        return preg_replace('/\D+/', '', trim($data));
    }


    public function setCpfCnpj(string $cpfCnpj){
        $cpfCnpj = $this->clear($cpfCnpj);
        if(strlen($cpfCnpj)==14){
            $this->cpfCnpj = new Cnpj($cpfCnpj);
        }elseif(strlen($cpfCnpj)==11){
            $this->cpfCnpj = new Cpf($cpfCnpj);
        }
    }

    public function isCpf(){
        return is_a($this->cpfCnpj, Cpf::class);
    }

    public function isCnpj(){
        return is_a($this->cpfCnpj, Cnpj::class);
    }

    public function __toString()
    {
        return $this->cpfCnpj;
    }


}