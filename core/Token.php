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

    protected User $user;

    function __construct($token)
    {
        $explode = explode(".", $token);
        if (count($explode) !== 2) throw new \Exception("Invalid token");
        if (base64_encode(base64_decode($explode[0], true)) !== $explode[0]) throw new \Exception("Invalid token");
        if (base64_encode(base64_decode($explode[1], true)) !== $explode[1]) throw new \Exception("Invalid token");

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

    function getUser(): User
    {
        return $this->user;
    }

    function getApplication(): string
    {
        return $this->data["application"];
    }

    function getExpire(): int
    {
        return $this->data["expire"];
    }

    function checkExpire(): bool
    {
        if ($this->data["expire"] < time()) {
            return false;
        } else {
            return true;
        }
    }

    function identify(): array
    {
        if (!$this->hasScope("identify")) {
            throw new \Exception("Invalid scope");
        }
        if (!$this->checkExpire()) {
            throw new \Exception("Token expired");
        }
        if (!$this->checkVerify()) {
            throw new \Exception("Token not verified");
        }

        return [
            "username" => $this->user->getUsername(),
            "application" => $this->data["application"],
            "scopes" => $this->data["scopes"],
            "servr" => $this->data["server"]

        ];
    }
}
