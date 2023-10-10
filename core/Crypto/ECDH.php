<?php

namespace LennisDev\XAuth\Crypto;

require_once __DIR__ . '/Utils.php';

use LennisDev\XAuth\Crypto\Utils;

class ECDH
{
    public static function encrypt($message, $publicKey, $secretKey): string
    {
        $nonce = random_bytes(SODIUM_CRYPTO_BOX_NONCEBYTES);
        $encrypted = sodium_crypto_box(
            $message,
            $nonce,
            sodium_crypto_box_keypair_from_secretkey_and_publickey(
                Utils::base642bin(json_decode($secretKey, true)["secret"]["ecdh"]),
                Utils::base642bin(json_decode($publicKey, true)["public"]["ecdh"])
            )
        );
        return Utils::bin2base64($nonce) . "." . Utils::bin2base64($encrypted);
    }
    public static function decrypt($message, $publicKey, $secretKey): string
    {
        $message = explode(".", $message);
        $nonce = Utils::base642bin($message[0]);
        $encrypted = Utils::base642bin($message[1]);
        return sodium_crypto_box_open(
            $encrypted,
            $nonce,
            sodium_crypto_box_keypair_from_secretkey_and_publickey(
                Utils::base642bin(json_decode($secretKey, true)["secret"]["ecdh"]),
                Utils::base642bin(json_decode($publicKey, true)["public"]["ecdh"])
            )
        );
    }
}
