<?php

namespace LennisDev\XAuth\Request;

require_once __DIR__ . "/../User.php";
require_once __DIR__ . "/../GenToken.php";

use LennisDev\XAuth\GenToken;
use LennisDev\XAuth\User;

class Authorize
{
    public static function exec(\LennisDev\XAuth\Request $obj)
    {
        $obj->checkAuth();
        if (!$obj->getToken()->hasScope("authorize")) {
            $obj->error("Token does not have authorize scope");
            return;
        }
        if (!isset($obj->getRequestData()["scopes"]))
            $obj->error("Scopes not set");
        else {

            $token = new GenToken([
                "username" => $obj->getToken()->getUser()->getUsername(),
                "expire" => time() + 3600
            ]);

            foreach ($obj->getRequestData()["scopes"] as $scope) {
                $token->addScope($scope);
            }
            $token->sign();
            $obj->return(true, [
                "token" => $token->getToken()
            ]);
        }
    }
}
