<?php
date_default_timezone_set("Asia/Kuala_Lumpur");

/*
** START - Database Configuration
** ***************************************/
$default_db = "localhost";
$db_debug_enable = true;

$list_db = Array(
    'localhost'   => Array(
        "HOSTNAME"   => "localhost",
        "DATABASE"   => "soulfame",
        "USERNAME"   => "root",
        "PASSWORD"   => "",
    ),
);

$db_conf = $list_db[$default_db];
/* ***************************************
** END - Database Configuration
*/


/*
** START - Encyrption Password
**
** ***************************************/
$saltkeys = Array(
    "main"  => "mainpurposepasswordencryption34634634653214234023895028350392850665",
    "user"  => "userdetailpasswordencryption09346u309460948603934564636390348509332",
);
/* ***************************************
** END - Encryption Password
*/

?>
