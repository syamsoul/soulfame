<?php
require_once dirname(__FILE__) . "/incl/class/function.php";

resetPath(dirname(__FILE__), get_url_base_path());

header("Location: forbidden.php");
?>
