<?php

namespace LennisDev\XAuth\Crypto;

use LennisDev\XAuth\Crypto\Utils as CryptoUtils;

class Utils
{
    public static function bin2base64(string $bin)
    {
        return sodium_bin2base64($bin, SODIUM_BASE64_VARIANT_ORIGINAL);
    }

    public static function base642bin(string $base64)
    {
        return sodium_base642bin($base64, SODIUM_BASE64_VARIANT_ORIGINAL);
    }
    public static function getPublicKeyFromSecretKey(string $secretKey): string
    {
        return json_encode(array(
            "public" => json_decode($secretKey, true)["public"],
        ));
    }
    public static function getKeyFromFile(string $file): string
    {
        return json_encode(json_decode(file_get_contents($file), true));
    }
}
