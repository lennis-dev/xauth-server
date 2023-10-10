<?php

namespace LennisDev\XAuth;

require_once __DIR__ . '/Crypto/ECDH.php';
require_once __DIR__ . '/Crypto/ECDSA.php';
require_once __DIR__ . '/Crypto/Key.php';
require_once __DIR__ . '/Crypto/Utils.php';
require_once __DIR__ . '/Utils.php';
require_once __DIR__ . '/Config.php';

use LennisDev\XAuth\Crypto\ECDH;
use LennisDev\XAuth\Crypto\ECDSA;
use LennisDev\XAuth\Crypto\Key;
use LennisDev\XAuth\Crypto\Utils;

class Crypto
{
    static function generateKeyPair(): array
    {
        return Key::generate();
    }

    static function verify($data, $sign, $keyRing): bool
    {
        return ECDSA::verify($data, $sign, $keyRing);
    }

    static function sign($data, $keyRing): string
    {
        return ECDSA::sign($data, $keyRing);
    }

    static function encrypt($data, $public, $private): string
    {
        return ECDH::encrypt($data, $public, $private);
    }

    static function decrypt($data, $public, $private): string
    {
        return ECDH::decrypt($data, $public, $private);
    }

    static function getKeyFromFile($file): string
    {
        return Utils::getKeyFromFile($file);
    }
}
