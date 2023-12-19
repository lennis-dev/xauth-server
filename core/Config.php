<?php

namespace LennisDev\XAuth;

require_once __DIR__ . "/../config.php";

class Config
{
    static public function getDataDir(): string
    {
        global $config;
        return realpath($config["dataDir"]);
    }
    static public function getWhitelistDirs(): array
    {
        $config = [];
        $config["whitelistDirs"] = [
            Self::getDataDir() . "/users/",
            Self::getDataDir() . "/keys/",
        ];
        return $config["whitelistDirs"];
    }
    static function config(): array
    {
        global $config;
        $config["whitelistDirs"] = Self::getWhitelistDirs();
        $config["keyRing"] = json_encode(Utils::readJSONSecure(Self::getDataDir() . "/keys/secretKey.json"));
        return $config;
    }
    static function getKeyRing(): string
    {
        return Self::config()["keyRing"];
    }
    static function getServerName(): string
    {
        return $_SERVER["SERVER_NAME"];
    }

    static function getUsersDir(): string
    {
        return Self::getDataDir() . "/users/";
    }
}
