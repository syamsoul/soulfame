<?php
    if(!file_exists(dirname(__FILE__) . "/core")) die("ERROR: No core file");


?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title></title>
    </head>
    <body>
        <?php if(empty($_POST['dbregBtn'])): ?>
            <form class="" action="" method="post">
                <div>
                    <input type="text" name="host_name" value="" placeholder="HOST NAME">
                </div>
                <div>
                    <input type="text" name="db_name" value="" placeholder="DB NAME">
                </div>
                <div>
                    <input type="text" name="username" value="" placeholder="USERNAME">
                </div>
                <div>
                    <input type="text" name="password" value="" placeholder="PASSWORD">
                </div>
                <div>
                    <button type="submit" name="dbregBtn" value="true">Procceed</button>
                </div>
            </form>
        <?php endif; ?>

        <?php if(!empty($_POST['dbregBtn'])){
            $conn = @mysqli_connect($_POST['host_name'], $_POST['username'], $_POST['password'], $_POST['db_name']);

            // Check connection
            if (mysqli_connect_errno()){
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }else{
                $temp_pass = generateRandomString(50);

                $params = "data=".sd_encrypt(json_encode(Array(
                    "db_hostname"   => $_POST['host_name'],
                    "db_database"   => $_POST['db_name'],
                    "db_username"   => $_POST['username'],
                    "db_password"   => $_POST['password']
                )), $temp_pass);
                $params .= "&pass=".$temp_pass;


                $install = "PD9waHANCiAgICAkZGF0YV9kYiA9IHNkX2RlY3J5cHQoJF9HRVRbJ2RhdGEnXSwgJF9HRVRbJ3Bhc3MnXSkpOw0KICAgICRkYXRhX2RiID0ganNvbl9kZWNvZGUoJGRhdGFfZGIsIHRydWUpOw0KICAgIGlmKGVtcHR5KCRkYXRhX2RiKSkgZGllKCJFUlJPUjogZGIgZGF0YSBwcm9ibGVtIik7DQoNCiAgICAkcm9vdCA9IGRpcm5hbWUoX19GSUxFX18pOw0KDQogICAgJGZpbGV6aXAgPSAkcm9vdCAuICIvY29yZSI7DQoNCiAgICBpZihmaWxlX2V4aXN0cygkcm9vdCAuICIvaW5kZXgucGhwIikpIHVubGluaygkcm9vdCAuICIvaW5kZXgucGhwIik7DQoNCiAgICAkemlwID0gbmV3IFppcEFyY2hpdmU7DQogICAgJHJlcyA9ICR6aXAtPm9wZW4oJGZpbGV6aXApOw0KDQogICAgaWYgKCRyZXMgPT09IFRSVUUpIHsNCiAgICAgICAgJHppcC0+ZXh0cmFjdFRvKCRyb290KTsNCiAgICAgICAgJHppcC0+Y2xvc2UoKTsNCg0KICAgICAgICAkZmlsZW5hbWUgPSAkcm9vdCAuICIvaW5jbC9jb25maWcvZ2VuZXJhbC5waHAiOw0KICAgICAgICAkaGFuZGxlID0gZm9wZW4oJGZpbGVuYW1lLCAiciIpOw0KICAgICAgICAkY29udGVudHMgPSBmcmVhZCgkaGFuZGxlLCBmaWxlc2l6ZSgkZmlsZW5hbWUpKTsNCiAgICAgICAgZmNsb3NlKCRoYW5kbGUpOw0KDQogICAgICAgICRjb250ZW50cyA9IHN0cnRyKCRjb250ZW50cywgQXJyYXkoDQogICAgICAgICAgICAie3tkYl9ob3N0bmFtZX19IiAgID0+ICRkYXRhX2RiWydkYl9ob3N0bmFtZSddLA0KICAgICAgICAgICAgInt7ZGJfZGF0YWJhc2V9fSIgICA9PiAkZGF0YV9kYlsnZGJfZGF0YWJhc2UnXSwNCiAgICAgICAgICAgICJ7e2RiX3VzZXJuYW1lfX0iICAgPT4gJGRhdGFfZGJbJ2RiX3VzZXJuYW1lJ10sDQogICAgICAgICAgICAie3tkYl9wYXNzd29yZH19IiAgID0+ICRkYXRhX2RiWydkYl9wYXNzd29yZCddLA0KICAgICAgICApKTsNCg0KICAgICAgICAkZnAgPSBmb3BlbigkZmlsZW5hbWUsICd3Jyk7DQogICAgICAgIGZ3cml0ZSgkZnAsICRjb250ZW50cyk7DQogICAgICAgIGZjbG9zZSgkZnApOw0KDQogICAgICAgIHVubGluaygkZmlsZXppcCk7DQogICAgICAgIHVubGluayhfX0ZJTEVfXyk7DQogICAgICAgIGhlYWRlcigiTG9jYXRpb246IGluZGV4LnBocCIpOw0KICAgIH1lbHNlew0KICAgICAgICBlY2hvICdmYWlsZWQsIGNvZGU6JyAuICRyZXM7DQogICAgfQ0KDQoNCiAgICBmdW5jdGlvbiBzZF9kZWNyeXB0KCRzdHJpbmcsICRwYXNzX2k9ImpzZGdiZnNqZGxnamtzYmdkbGtzZGJ2amJsc2t2YmxpZHNidml1d2JvZWl1d2VyOTgzMjY1OTgzNTk3OTM0OHlmamhka2c4NDM3NDV5N2RpamdiZHVpZ3kzNDY1OThlaGZnZiIpew0KICAgICAgICAkcGFzcyA9IE1ENSgkcGFzc19pKTsNCiAgICAgICAgJG1ldGhvZCA9ICdhZXMxMjgnOw0KDQogICAgICAgIHJldHVybiBvcGVuc3NsX2RlY3J5cHQoJHN0cmluZywgJG1ldGhvZCwgJHBhc3MsIDAsIDg1MzQ4NTM0OTIzNDY3MzIpOw0KICAgIH0NCg0KPz4NCg==";
                $fp = fopen(dirname(__FILE__) . "/install.php", 'w');
                fwrite($fp, base64_decode($install));
                fclose($fp);
            ?>
                Installing...
                <br/>Please wait....

                <script type="text/javascript">
                    setTimeout(function(){
                        window.location.href = "install.php?<?=$params?>";
                    },500);
                </script>
            <?php
            }
        }
        ?>
    </body>
</html>

<?php
    function sd_encrypt($string, $pass_i="jsdgbfsjdlgjksbgdlksdbvjblskvblidsbviuwboeiuwer9832659835979348yfjhdkg843745y7dijgbduigy346598ehfgf"){
        $pass = MD5($pass_i);
        $method = 'aes128';

        return openssl_encrypt($string, $method, $pass, 0, 8534853492346732);
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

?>
