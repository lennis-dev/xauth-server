<?php

namespace LennisDev\XAuth\User;

require_once __DIR__ . "/../User.php";
require_once __DIR__ . "/../Config.php";
require_once __DIR__ . "/../Utils.php";

use LennisDev\XAuth\User;
use LennisDev\XAuth\Config;
use LennisDev\XAuth\Utils;

class Create extends User
{
    public function __construct(string $username, string $password, string $email)
    {
        if (is_dir(Config::getUsersDir() . $username))
            throw new \Exception("User already exists");
        $this->username = $this->validateUsername($username);
        mkdir(Config::getUsersDir() . $this->username);
        Utils::writeJSONSecure(Config::getUsersDir() . $this->username . "/data.json", []);
        parent::__construct($this->username);
        $this->setPasswordHash($password);
    }
}
