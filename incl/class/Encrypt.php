<?php
class SoulEncrypt{

    private $saltkey;


    function __construct($saltkey){

        $this->saltkey = $saltkey;

    }


    public function encode($data){

        $curr_saltkey = $this->saltkey;

        $curr_saltkey_reverse = str_split($curr_saltkey);
        $curr_saltkey_reverse = substr(implode("", array_reverse($curr_saltkey_reverse)), 0, 16);

        return base64_encode(openssl_encrypt($data, "AES-256-CBC", MD5($curr_saltkey), 0, $curr_saltkey_reverse));

    }


    public function decode($data){

        $curr_saltkey = $this->saltkey;

        $curr_saltkey_reverse = str_split($curr_saltkey);
        $curr_saltkey_reverse = substr(implode("", array_reverse($curr_saltkey_reverse)), 0, 16);

        return openssl_decrypt(base64_decode($data), "AES-256-CBC", MD5($curr_saltkey), 0, $curr_saltkey_reverse);

    }

}

?>
