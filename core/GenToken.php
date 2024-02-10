<?php

namespace LennisDev\XAuth;

require_once __DIR__ . '/Crypto.php';
require_once __DIR__ . '/Config.php';

use LennisDev\XAuth\Crypto;
use LennisDev\XAuth\Config;

class GenToken
{
    private array $data = [];
    private string $sign = "";

    function __construct(array $data)
    {
        $this->data = $data;
        $this->data["created"] = time();
        $this->data["scopes"] = [];
        $this->data["server"] = $_SERVER["SERVER_NAME"];
    }

    function addScope(string $scope)
    {
        if (!in_array($scope, $this->data["scopes"]))
            $this->data["scopes"][] = $scope;
    }


    function setScopes(array $scopes)
    {
        $this->data["scopes"] = $scopes;
    }

    function setUserName(string $username)
    {
        $this->data["username"] = $username;
    }

    function setExpire(int $expire)
    {
        $this->data["expire"] = $expire;
    }

    function setApplication(string $application)
    {
        $this->data["application"] = $application;
    }

    function getToken(): string
    {
        return base64_encode(json_encode($this->data)) . "." . $this->sign;
    }

    function sign()
    {
        $this->sign = Crypto::sign(json_encode($this->data), Config::getKeyRing());
    }
}
