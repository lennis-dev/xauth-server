<?php

namespace LennisDev\XAuth\Crypto;

require_once __DIR__ . '/Utils.php';

use LennisDev\XAuth\Crypto\Utils;

class ECDSA
{
    public static function sign($message, $secretKey): string
    {
        return Utils::bin2base64(sodium_crypto_sign_detached(
            $message,
            Utils::base642bin(
                json_decode($secretKey, true)["secret"]["ecdsa"]
            )
        ));
    }
    public static function verify($message, $signature, $publicKey): bool
    {
        return sodium_crypto_sign_verify_detached(
            Utils::base642bin($signature),
            $message,
            Utils::base642bin(
                json_decode($publicKey, true)["public"]["ecdsa"]
            )
        );
    }
}
