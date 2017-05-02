<?php

namespace App\Controller;

class Chapter9Controller extends Chapter
{
    protected function code60()// Symmetric Encryption
    {
        $this->getCode(__FILE__, 'code60');
        // If there are repeated sequences in encrypted data, an attacker could assume that the corresponding sequences
        // in the message were also identical. The IV prevents the appearance of corresponding duplicate character
        // sequences in the ciphertext
        //<code60>
        // mcrypt_encrypt is deprecated

        //</code60>
        $this->view->set('result', $this->view->render('sample/code60'));
    }

    protected function code61()// Asymmetric Encryption
    {
        $this->getCode(__FILE__, 'code61');
        //<code61>
        //</code61>
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