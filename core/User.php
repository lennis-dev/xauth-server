<?php

namespace LennisDev\XAuth;

require_once __DIR__ . "/Config.php";
require_once __DIR__ . "/Utils.php";

use LennisDev\XAuth\Config;
use LennisDev\XAuth\Utils;

class User
{
    protected string $username = "";
    protected array|false $data = [];
    protected bool $exists = false;

    public function __construct(string $username)
    {
        $this->username = strtolower($username);
        if (preg_match("/[^a-z0-9._]/", $this->username)) return;
        $this->data = Utils::readJSONSecure(Config::getDataDir() . "/users/" . $this->username . "/data.json");
        $this->exists = $this->data !== false;
    }

    public function getUsername(): string|null
    {
        if (!$this->exists) return null;
        return $this->username;
    }

    public function writeUserData(): bool
    {
        if (!$this->exists) return false;

        return Utils::writeJSONSecure(Config::getDataDir() . "/users/" . $this->username . "/data.json", $this->data);
    }

    public function getData(): array|false
    {
        if (!$this->exists) return false;
        return $this->data;
    }

    function exists(): bool
    {
        return $this->exists;
    }

    function checkPassword(string $password, $time): bool
    {
        if (!$this->exists) return false;
        if ($time > time() - 60 && $time <= time()) {
            return hash("sha512", $this->data["passwordHash"] . $time) === $password;
        } else {
            return false;
        }
    }
}
