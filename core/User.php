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
        $this->username = $this->validateUsername($username);
        $this->data = Utils::readJSONSecure(Config::getDataDir() . "/users/" . $this->username . "/data.json");
        $this->exists = $this->data !== false;
    }

    public function getUsername(): string|null
    {
        if (!$this->exists) return null;
        return $this->username;
    }

    public function validateUsername(string $username): string
    {
        $username = strtolower($username);
        if (!preg_match("/^[a-z0-9-.]{3,32}$/", $username)) {
            throw new \Exception("Invalid username");
        }
        return $username;
    }

    public function writeUserData(): bool
    {
        if (!$this->exists) return false;

        return Utils::writeJSONSecure(Config::getDataDir() . "/users/" . $this->username . "/data.json", $this->data);
    }

    public function setData(string $key, $value): void
    {
        $data = Utils::readJSONSecure(Config::getUsersDir() . $this->username . "/data.json");
        $data[$key] = $value;
        Utils::writeJSONSecure(Config::getUsersDir() . $this->username . "/data.json", $data);
    }

    public function getData(string $key)
    {
        $data = Utils::readJSONSecure(Config::getUsersDir() . $this->username . "/data.json");
        return $data[$key];
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

    function setPasswordHash(string $passwordHash): void
    {
        $this->data["passwordHash"] = $passwordHash;
        $this->writeUserData();
    }
}
