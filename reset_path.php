<?php
require_once dirname(__FILE__) . "/incl/config/general.php";
require_once dirname(__FILE__) . "/incl/function.php";

resetPath(dirname(__FILE__), BASE_PATH);

header("Location: forbidden.php");
?>
