<?php

namespace LennisDev\XAuth\Request;

require_once __DIR__ . "/../User.php";
require_once __DIR__ . "/../GenToken.php";

use LennisDev\XAuth\GenToken;
use LennisDev\XAuth\User;

class Login
{
    public static function exec(\LennisDev\Xauth\Request $obj)
    {
        if (!isset($obj->getRequestData()["auth"]["username"]))
            $obj->error("Username not set");
        else if (!isset($obj->getRequestData()["auth"]["password"]))
            $obj->error("Password not set");
        else {
            $username = $obj->getRequestData()["auth"]["username"];
            $password = $obj->getRequestData()["auth"]["password"];
            $user = new User($username);
            if (!$user->exists())
                $obj->error("User does not exist");
            else if (!$user->checkPassword(
                $password,
                $obj->getRequestData()["auth"]["time"]
            )) $obj->error("Password is incorrect");
            else {
                $token = new GenToken([
                    "username" => $username,
                    "created" => time(),
                    "expire" => time() + 3600
                ]);
                $token->setApplication($_SERVER["SERVER_NAME"]);
                $token->addScope("authorize");
                $token->sign();
                $obj->return(true, [
                    "token" => $token->getToken()
                ]);
            }
        }
    }
}
