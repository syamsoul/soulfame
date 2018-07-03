<?php
    require_once DIRNAME(__FILE__) . "/incl/class/function.php";
    if($_SERVER['REQUEST_URI'] != $_SERVER['SCRIPT_NAME']) header("Location: ".$_SERVER['SCRIPT_NAME']);
    else header("Location: ".(empty(get_url_base_path()) ? "/" : get_url_base_path()));
?>
