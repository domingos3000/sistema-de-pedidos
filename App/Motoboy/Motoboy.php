<?php

namespace App\Motoboy;

// @session_start();

include_once __DIR__ . './../../components/connect.php';
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
        $stmt->execute([self::$id, self::$nome, self::$email, self::$senha, 'false']);

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

}