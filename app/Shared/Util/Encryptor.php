<?php
namespace App\Shared\Util;

class Encryptor
{

    public static function encrypt($data)
    {   
        $llave="*";
        $size = strlen($llave);
        $ultimo_caracter_llave = $llave[$size-1];
        while ($ultimo_caracter_llave == "*") {
            $expire = $data;
            $key  = env('KEY_ENCRYPT');
            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
            $encrypted=openssl_encrypt($expire, "aes-256-cbc", $key, 0, $iv);
            $llave = base64_encode($encrypted."::".$iv);
            $size = strlen($llave);
            $ultimo_caracter_llave = $llave[$size-1];
            if (strpos($llave, ' ') !== false) {
                $ultimo_caracter_llave = "*";
            }
        }
        return $llave;
    }

    public static function decrypt($data)
    {
        try {
            $key  = env('KEY_ENCRYPT');
            list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
            $result = openssl_decrypt($encrypted_data, 'aes-256-cbc', $key, 0, $iv);
            return $result == false ? null : $result;
        } catch (\Throwable $th) {
            return null;
        }
    }
}
