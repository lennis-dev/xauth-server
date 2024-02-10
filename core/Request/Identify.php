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
            if (!$obj->getToken()->hasScope("identify")) {
                $obj->error("Token does not have identify scope");
                return;
            }
            if (!$obj->getToken()->checkExpire()) {
                $obj->error("Token has expired");
                return;
            }
            if (!$obj->getToken()->checkVerify()) {
                $obj->error("Token is invalid");
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
