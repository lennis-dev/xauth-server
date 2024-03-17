<?php

namespace LennisDev\XAuth;

require_once __DIR__ . "/Config.php";

use LennisDev\XAuth\Config;

class Utils
{
    public static function readJSONSecure(string $path): array|false
    {
        $whitelistDirs = Config::getWhitelistDirs();
        $realdpath = realpath($path);
        if ($realdpath !== false) {
            foreach ($whitelistDirs as $dir) {
                if (str_starts_with($realdpath,   $dir) && file_exists($path)) {
                    return json_decode(file_get_contents($path), true);
                }
            }
        }
        return false;
    }

    public static function writeJSONSecure(string $path, array $data): bool
    {
        $whitelistDirs = Config::getWhitelistDirs();
        $realdpath = realpath($path);
        if ($realdpath !== false) {
            foreach ($whitelistDirs as $dir) {
                if (str_starts_with($realdpath, $dir)) {
                    return file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT)) !== false;
                }
            }
        }
        return false;
    }
}
