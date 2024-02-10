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
            $return = $obj->getToken()->identify();
            $obj->return(true, $return);
        } catch (\Exception $e) {
            $obj->error($e->getMessage());
        }
    }
}
