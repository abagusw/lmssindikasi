<?php

namespace App\Libraries;

use Config\Encryption;
use Config\Services;

class MyEncrypter
{
    protected $encrypter;

    public function __construct()
    {
        $config = new Encryption();
        $config->driver = 'OpenSSL';
        $config->cipher = 'AES-256-GCM';

        $config->key = hex2bin(env('encryption.key'));


        $this->encrypter = Services::encrypter($config, false);
    }

    public function encrypt(string $data): string
    {
        return base64_encode($this->encrypter->encrypt($data));
    }

    public function decrypt(string $ciphertext): string
    {
        return $this->encrypter->decrypt(base64_decode($ciphertext));
    }
}