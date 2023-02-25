<?php
if(!function_exists('e_nzm')){
    function e_nzm($value)
    {
        $ciphering = "AES-128-CBC";
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;
        $encryption_iv = '1234567891011121';
        $encryption_key = 'NZM_Encryption';
        $encryption = bin2hex(openssl_encrypt($value, $ciphering, $encryption_key, $options, $encryption_iv));
        return $encryption;
    }

}

if(!function_exists('d_nzm')){
    function d_nzm($value)
    {
        $ciphering = "AES-128-CBC";
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;
        $decryption_iv = '1234567891011121';
        $decryption_key = 'NZM_Encryption';
        $decryption = openssl_decrypt(hex2bin($value), $ciphering, $decryption_key, $options, $decryption_iv);
        return $decryption;
    }
}
?>