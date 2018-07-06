<?php
    $data_db = sd_decrypt($_GET['data'], $_GET['pass']);
    $data_db = json_decode($data_db, true);
    if(empty($data_db)) die("ERROR: db data problem");

    $root = dirname(__FILE__);

    $filezip = $root . "/core";

    if(file_exists($root . "/index.php")) unlink($root . "/index.php");

    $zip = new ZipArchive;
    $res = $zip->open($filezip);

    if ($res === TRUE) {
        $zip->extractTo($root);
        $zip->close();

        $filename = $root . "/incl/config/general.php";
        $handle = fopen($filename, "r");
        $contents = fread($handle, filesize($filename));
        fclose($handle);

        $contents = strtr($contents, Array(
            "{{db_hostname}}"   => $data_db['db_hostname'],
            "{{db_database}}"   => $data_db['db_database'],
            "{{db_username}}"   => $data_db['db_username'],
            "{{db_password}}"   => $data_db['db_password'],
        ));

        $fp = fopen($filename, 'w');
        fwrite($fp, $contents);
        fclose($fp);

        unlink($filezip);
        unlink(__FILE__);
        header("Location: index.php");
    }else{
        echo 'failed, code:' . $res;
    }


    function sd_decrypt($string, $pass_i="jsdgbfsjdlgjksbgdlksdbvjblskvblidsbviuwboeiuwer9832659835979348yfjhdkg843745y7dijgbduigy346598ehfgf"){
        $pass = MD5($pass_i);
        $method = 'aes128';

        return openssl_decrypt(base64_decode($string), $method, $pass, 0, 8534853492346732);
    }

?>
