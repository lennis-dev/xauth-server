<?php

require_once __DIR__ . "/core/Crypto.php";
use LennisDev\XAuth\Crypto;
require_once __DIR__ . "/config.php";
if (!is_dir($config["dataDir"])) {
    mkdir($config["dataDir"], 0755, true);
}
if (!is_dir($config["dataDir"] . "users/")) {
    mkdir($config["dataDir"] . "users/", 0755, true);
}
if (!is_dir($config["dataDir"] . "keys/")) {
    mkdir($config["dataDir"] . "keys/", 0755, true);
}
if (!is_file($config["dataDir"] . "keys/secretKey.json")) {
    file_put_contents(
        $config["dataDir"] . "keys/secretKey.json",
        json_encode(Crypto::generateKeyPair(), JSON_PRETTY_PRINT),
    );
}
