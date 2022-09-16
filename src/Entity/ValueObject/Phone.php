<?php

namespace App\Entity\ValueObject;

use ErrorException;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class Phone
{
    #[ORM\Column(length: 13)]
    private $phone;

    public function __construct(string $phone)
    {
        $this->setPhone($phone);
    }

    public function getPhone(){
        return $this->phone;
    }

    public function getDdd(){
        return substr($this->phone, 0, 2);
    }

    private function clear(string $telefone){
        return preg_replace('/\D+/', '', trim($telefone));
    }

    private function valida($telefone)
    {
        $telefone = $this->clear($telefone);
        $numeroDigitos = strlen($telefone);

        if ($numeroDigitos < 10 || $numeroDigitos > 11) {
            return false;
        }

        if (preg_match('/^[1-9]{2}([0-9]{8}|9[0-9]{8})$/', $telefone)) {
            return true;
        } else {
            return false;
        }
    }

    private function setPhone(string $phoneString)
    {
        if(!$this->valida($phoneString)){
            throw new ErrorException("Phone is not valid");
        }

        $this->phone = $this->clear($phoneString);
    }
}
