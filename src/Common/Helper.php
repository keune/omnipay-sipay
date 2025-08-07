<?php

namespace Keune\OmnipaySipay\Common;

class Helper
{
    public static function generateHash(string $data, string $appSecret): string
    {
        $iv = substr(sha1(mt_rand()), 0, 16);
        $password = sha1($appSecret);

        $salt = substr(sha1(mt_rand()), 0, 4);
        $saltWithPassword = hash('sha256', $password.$salt);

        $encrypted = openssl_encrypt("$data", 'aes-256-cbc', "$saltWithPassword", 0, $iv);

        $msg_encrypted_bundle = "$iv:$salt:$encrypted";

        return str_replace('/', '__', $msg_encrypted_bundle);
    }

    public static function validateHashKey(string $hashKey, string $secretKey): array
    {
        $status = $currencyCode = '';
        $total = $invoiceId = $orderId = 0;

        if (!empty($hashKey)) {
            $hashKey = str_replace('__', '/', $hashKey);
            $password = sha1($secretKey);

            $components = explode(':', $hashKey);
            if (count($components) > 2) {
                $iv = $components[0] ?? '';
                $salt = $components[1] ?? '';
                $salt = hash('sha256', $password.$salt);
                $encryptedMsg = $components[2] ?? '';

                $decryptedMsg = openssl_decrypt($encryptedMsg, 'aes-256-cbc', $salt, 0, $iv);

                if (str_contains($decryptedMsg, '|')) {
                    $array = explode('|', $decryptedMsg);
                    $status = $array[0] ?? 0;
                    $total = $array[1] ?? 0;
                    $invoiceId = $array[2] ?? '0';
                    $orderId = $array[3] ?? 0;
                    $currencyCode = $array[4] ?? '';
                }
            }
        }

        return [$status, $total, $invoiceId, $orderId, $currencyCode];
    }
}
