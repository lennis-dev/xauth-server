<?php

namespace LennisDev\XAuth\Request;

require_once __DIR__ . "/../User/Create.php";

use LennisDev\XAuth\User\Create as CreateUser;

class Register
{
    public static function exec(\LennisDev\XAuth\Request $obj)
    {
        try {
            $username = $obj->getRequestData()["username"];
            $password = $obj->getRequestData()["password"];
            $email = $obj->getRequestData()["email"];
            $user = new CreateUser($username, $password, $email);
            $obj->return(true, array("message" => "created user" . $user->getUsername()));
        } catch (\Exception $e) {
            $obj->error($e->getMessage());
        }
    }
}
