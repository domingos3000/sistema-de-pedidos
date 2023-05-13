<?php

namespace App\User;

class UserDao {
    private static $name;
    public static function sayMyName($name){

        self::$name = $name;
        return "Your name is " . self::$name . "!";
    }

}
