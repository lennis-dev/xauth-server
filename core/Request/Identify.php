<?php

namespace LennisDev\XAuth\Request;

require_once __DIR__ . "/../User.php";
require_once __DIR__ . "/../GenToken.php";

use LennisDev\XAuth\GenToken;
use LennisDev\XAuth\User;

class Identify
{
    public static function exec(\LennisDev\XAuth\Request $obj)
    {
        try {
            $obj->checkAuth();
            if (!$obj->getToken()->hasScope("identify")) {
                $obj->error("Token does not have identify scope");
                return;
            }
            $obj->return(true, [
                "username" => $obj->getToken()->getUser()->getUsername()
            ]);
        } catch (\Exception $e) {
            $obj->error($e->getMessage());
        }
    }
}
