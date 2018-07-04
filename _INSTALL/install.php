<?php
    $root = dirname(__FILE__);

    $filezip = $root . "/core";

    unlink($root . "/index.php");

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
            "{{db_hostname}}"   => $_GET['host_name'],
            "{{db_database}}"   => $_GET['db_name'],
            "{{db_username}}"   => $_GET['username'],
            "{{db_password}}"   => $_GET['password'],
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
?>
