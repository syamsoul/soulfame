<?php
    if($_SERVER['REQUEST_URI'] != $_SERVER['SCRIPT_NAME']) header("Location: ".$_SERVER['SCRIPT_NAME']);
    else header("Location: login");
?>
