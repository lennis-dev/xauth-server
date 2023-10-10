<?php

namespace LennisDev\XAuth;

require_once __DIR__ . '/Crypto.php';
require_once __DIR__ . '/Config.php';
require_once __DIR__ . '/User.php';

use LennisDev\XAuth\Crypto;
use LennisDev\XAuth\Config;
use LennisDev\XAuth\User;

class Token
{
    protected $data = [];

    protected string $sign = "";

    protected string $serverKeyRing = "";

    public readonly User $user;

    function __construct($token)
    {
        $explode = explode(".", $token);
        $this->data = json_decode(base64_decode($explode[0]), true);
        $this->sign = $explode[1];
        $this->user = new User($this->data["username"]);
        $this->serverKeyRing = Config::getKeyRing();
    }
    function checkVerify(): bool
    {
        if ($this->data["expire"] < time()) return false;
        if ($this->data["created"] > time()) return false;
        if (!$this->user->exists()) return false;
        $verify = Crypto::verify(json_encode($this->data), $this->sign, $this->serverKeyRing);
        if ($verify) {
            return true;
        } else {
            return false;
        }
    }

    function hasScope(string $scope): bool
    {
        return in_array($scope, $this->data["scopes"]);
    }

    function getData(): array
    {
        return $this->data;
    }
}
