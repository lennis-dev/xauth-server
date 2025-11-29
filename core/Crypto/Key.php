<?php

namespace LennisDev\XAuth\Crypto;

require_once __DIR__ . "/Utils.php";

class Key
{
    public static function generate()
    {
        $cryptoBox = sodium_crypto_box_keypair();
        $cryptoBoxSign = sodium_crypto_sign_keypair();
        return [
            "public" => [
                "ecdh" => Utils::bin2base64(
                    sodium_crypto_box_publickey($cryptoBox),
                ),
                "ecdsa" => Utils::bin2base64(
                    sodium_crypto_sign_publickey($cryptoBoxSign),
                ),
            ],
            "secret" => [
                "ecdh" => Utils::bin2base64(
                    sodium_crypto_box_secretkey($cryptoBox),
                ),
                "ecdsa" => Utils::bin2base64(
                    sodium_crypto_sign_secretkey($cryptoBoxSign),
                ),
            ],
        ];
    }
}
