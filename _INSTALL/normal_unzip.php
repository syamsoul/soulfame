<?php
    $root = dirname(__FILE__);

    $filezip = $root . "/public.zip";

    if(file_exists($root . "/index.php")) unlink($root . "/index.php");

    $zip = new ZipArchive;
    $res = $zip->open($filezip);

    if ($res === TRUE) {
        $zip->extractTo($root);
        $zip->close();

        unlink($filezip);
        unlink(__FILE__);
        header("Location: index.php");
    }else{
        echo 'failed, code:' . $res;
    }
?>
