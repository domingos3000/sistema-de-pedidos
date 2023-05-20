<?php
require __DIR__ . './../vendor/autoload.php';

use Ramsey\Uuid\Uuid; //carregando a classe UUID
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException; //carregando as excessões

function gerandoIdUnico(){

    try {

        //Gerando um objeto UUID de versão 1 (baseada em tempo)
        // $uuid1 = Uuid::uuid1();
        // echo $uuid1->toString() . "\n"; // i.e. e4eaaaf2-d142-11e1-b3e4-080027620cdd
    
        //Gerando um objeto UUID de versão 3 (baseada em nome e usando hash MD5)
        // $uuid3 = Uuid::uuid3(Uuid::NAMESPACE_DNS, 'imasters.com');
        // echo $uuid3->toString() . "\n"; // i.e. 11a38b9a-b3da-360f-9353-a5a725514269
    
        //Gerando um objeto UUID de versão 4 (aleatório)
    
        $uuid4 = Uuid::uuid4();
        return $uuid4->toString(); // i.e. 25769c6c-d34d-4bfe-ba98-e0ee856f3e7a
    
        //Gerando um objeto UUID de versão 3 (baseada em nome e usando hash SHA1)
        // $uuid5 = Uuid::uuid5(Uuid::NAMESPACE_DNS, 'imasters.com');
        // echo $uuid5->toString() . "\n"; // i.e. c4a760a8-dbcf-5254-a0d9-6a4474bd1b62
    
    } catch (UnsatisfiedDependencyException $e) {
    
        // Caso ocorra algum erro:
        // echo 'Excessão: ' . $e->getMessage() . "\n";

        return rand(111111, 999999);
    
    }
}