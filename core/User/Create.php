<?php

namespace LennisDev\XAuth\User;

require_once __DIR__ . "../User.php";
require_once __DIR__ . "../Config.php";
require_once __DIR__ . "../Utils.php";

use LennisDev\XAuth\User;
use LennisDev\XAuth\Config;
use LennisDev\XAuth\Utils;

class Create extends User
{
    public function __construct(string $username)
    {
        if (!preg_match("/^[a-zA-Z0-9_]{3,16}$/", $username)) {
            throw new \Exception("Invalid username");
        }
        $this->username = $username;
        mkdir(Config::getUsersDir() . $this->username);
        $data = array();
        Utils::writeJSONSecure(Config::getUsersDir() . $this->username . "/data.json", $data);
    }

    public function getUsername(): string
    {
        return $this->username;
    }
}
