<?php

namespace App\Motoboy;

// @session_start();

include_once __DIR__ . './../db/db.php';
include_once __DIR__ . './../../functions/gerando-id-unico.php';

class Motoboy {

    private static $db;
    private static $id;
    private static $nome;
    private static $email;
    private static $senha;
    private static $disponivel;

    public function __construct($nome, $email, $senha){
        
        self::$db = db();
        self::$id = gerandoIdUnico();
        self::$nome = $nome;
        self::$email = $email;
        self::$senha = sha1($senha);
    }

    public static function register(){

        $stmt = self::$db->prepare("INSERT INTO motoboy (id, nome, email, senha, disponivel) VALUES (?,?,?,?,?)");
        $stmt->execute([self::$id, self::$nome, self::$email, self::$senha, 'true']);

    }

    public static function login($email, $password){
        $pass = sha1($password);

        $stmt = db()->prepare("SELECT * FROM `motoboy` WHERE email = ? AND senha = ? LIMIT 1");
        $stmt->execute([$email, $pass]);

        if($stmt->rowCount() <= 0) return false;

        $motoboyResult = $stmt->fetch(\PDO::FETCH_ASSOC);
        $_SESSION['motoboy_id'] = $motoboyResult['id'];

        return true;

    }

    public static function findAvailable(){
        $stmt = db()->prepare("SELECT * FROM `motoboy` WHERE `disponivel` = ?");
        $stmt->execute(['true']);

        if($stmt->rowCount() > 0){
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
    }

    public static function selectMotoboy($idMotoboy, $idPedido){

            if(empty($idMotoboy) || empty($idPedido)) return false;
 
            $stmt = db()->prepare("UPDATE `motoboy` SET `disponivel` = ? WHERE `id` = ?");
            
            if($stmt->execute(["false", $idMotoboy])){
                $stmt = db()->prepare("UPDATE `pedidos` SET `motoboy_id` = ? WHERE `id` = ?");
                $stmt->execute([$idMotoboy, $idPedido]);
            }
    }

    public static function findMyTask($idMotoboy){

        $stmt = db()->prepare("SELECT * FROM pedidos WHERE `motoboy_id` = ? AND `confirmacao_motoboy` = 'false'");
        $stmt->execute([$idMotoboy]);

        if($stmt->rowCount() > 0){
            $pedidos = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            return $pedidos;
        }
    }

    public static function confirmPedido($idPedido, $status){

        $findMotoboy = db()->prepare("SELECT * FROM `pedidos` WHERE `id` = ?");
        $findMotoboy->execute([$idPedido]);

        if($findMotoboy->rowCount() > 0){
            
            $fetchData = $findMotoboy->fetch(\PDO::FETCH_ASSOC);
            $motoboyId = $fetchData['motoboy_id'];
        
            $update_status = db()->prepare("UPDATE `pedidos` SET confirmacao_motoboy = ? WHERE id = ?");
            $update_status->execute([$status, $idPedido]);
        
            $stmt = db()->prepare("UPDATE `motoboy` SET `disponivel` = ? WHERE `id` = ?");
            $stmt->execute(["true", $motoboyId]);
    
        }
    }

}


// print_r(Motoboy::confirmPedido("0a102c0b-2cfa-4a27-9e5a-e53f6e6913ae", "true"));