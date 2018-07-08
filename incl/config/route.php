<?php
if(!isset($authenticated_user) || !isset($pages)) $authenticated_user = false;


if(!$authenticated_user){

    $pages->setDefaultPage("/");
    $pages->addPage("/", "guest/main.php");
    $pages->addPage("admin", "admin/login.php");

}else{

    $pages->setDefaultPage("admin/main");
    $pages->addPage("admin/main", "admin/main.php");

}

$pages->addPage("img/{filename}", "image.php");
$pages->addPage("img/{folder}/{filename}", "image.php");

?>
