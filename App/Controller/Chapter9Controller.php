<?php

namespace App\Controller;

class Chapter9Controller extends Chapter
{
    protected function code60()// Symmetric Encryption
    {
        $this->getCode(__FILE__, 'code60');
        $this->view->set('link', [
            ['Symmetric-key algorithm', 'https://en.wikipedia.org/wiki/Symmetric-key_algorithm'],
            ['mcrypt_encrypt', 'http://php.net/manual/en/function.mcrypt-encrypt.php'],
            ['openssl_encrypt', 'https://secure.php.net/manual/en/function.openssl-encrypt.php'],
            ['openssl_decrypt', 'https://secure.php.net/manual/en/function.openssl-decrypt.php'],
        ]);
        // If there are repeated sequences in encrypted data, an attacker could assume that the corresponding sequences
        // in the message were also identical. The IV prevents the appearance of corresponding duplicate character
        // sequences in the ciphertext
        $this->beQuiet(false);
        //<code60>
        $algorithms = openssl_get_cipher_methods();
        $key = 'H6l97Ez9N57ciyDyZPIGbBi679C7AVv6';
        $plainText = 'Secure Coding is awesome!';
        $result = [];
        foreach ($algorithms as $algorithm) {
            $ivLength = openssl_cipher_iv_length($algorithm);
            $iv = openssl_random_pseudo_bytes($ivLength);
            $cipher = openssl_encrypt($plainText, $algorithm, $key, OPENSSL_RAW_DATA, $iv);
            if (!$cipher) continue;
            $plain = openssl_decrypt($cipher, $algorithm, $key, OPENSSL_RAW_DATA, $iv);
            $result[$algorithm] = [$ivLength, $cipher, $plain];
        }
        //</code60>
        $this->view->set('algorithms', $algorithms);
        $this->view->set('ciphers', $result);
        $this->view->set('result', $this->view->render('sample/code60'));
    }

    protected function code61()// Asymmetric Encryption
    {
        $this->getCode(__FILE__, 'code61');
        $this->view->set('link', [
            ['Public-key Cryptography', 'https://en.wikipedia.org/wiki/Public-key_cryptography'],
            ['Openssl Public Encrypt', 'https://secure.php.net/manual/en/function.openssl-public-encrypt.php'],
            ['Openssl Installation', 'https://secure.php.net/manual/en/openssl.installation.php'],
        ]);
        $this->view->set('commands', [
            ["Generating Key Pair", "openssl genrsa -out privkey.pem 1024"],
            ['Extracting Public Key', 'openssl rsa -in privkey.pem -pubout -out pubkey.pem']
        ]);
        //<code61>
        // todo: uncomment extension=php_openssl.dll
        $plainText = 'Awesome Secure Coding!';
        $private = file_get_contents("{$this->config->root}/resources/keys/privkey.pem");
        $public = file_get_contents("{$this->config->root}/resources/keys/pubkey.pem");
        openssl_public_encrypt($plainText, $pubCipher, $public);
        openssl_private_decrypt($pubCipher, $pubPlain, $private);
        openssl_private_encrypt($plainText, $privCipher, $private);
        openssl_public_decrypt($privCipher, $privPlain, $public);
        //</code61>
        $this->view->set('ciphers', [
            ['Encrypted With Public', $pubCipher, false],
            ['Decrypted With Private', $pubPlain, false],
            ['Encrypted With Private Key', $privCipher, false],
            ['Decrypted With Public Key', $privPlain, false],
            ['Public Key', $public, true],
            ['Private Key', $private, true]
        ]);
        $this->view->set('result', $this->view->render('sample/code61'));
    }

    protected function code62()// Hashing
    {
        $this->getCode(__FILE__, 'code62');
        // DOS attach on hashing
        //<code62>
        $salt = 'SomethingRnd0m';
        $pass = $this->request->post('password');
        if ($pass) {
            // Is there anything wrong?
            $hash = md5($salt);
            // $hash = md5($salt . md5($pass . $salt));
            // $hash = (strlen($pass) % 2 == 0) ? md5($salt . md5($pass . $salt)) : md5(md5($salt . $pass) . $salt);
            $this->view->set('hashedPassword', $hash);
        }
        //</code62>
        $this->view->set('result', $this->view->render('sample/code62'));
    }
}