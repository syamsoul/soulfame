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


                $install = "PD9waHANCiAgICAkZGF0YV9kYiA9IHNkX2RlY3J5cHQoJF9HRVRbJ2RhdGEnXSwgJF9HRVRbJ3Bhc3MnXSk7DQogICAgJGRhdGFfZGIgPSBqc29uX2RlY29kZSgkZGF0YV9kYiwgdHJ1ZSk7DQogICAgaWYoZW1wdHkoJGRhdGFfZGIpKSBkaWUoIkVSUk9SOiBkYiBkYXRhIHByb2JsZW0iKTsNCg0KICAgICRyb290ID0gZGlybmFtZShfX0ZJTEVfXyk7DQoNCiAgICAkZmlsZXppcCA9ICRyb290IC4gIi9jb3JlIjsNCg0KICAgIGlmKGZpbGVfZXhpc3RzKCRyb290IC4gIi9pbmRleC5waHAiKSkgdW5saW5rKCRyb290IC4gIi9pbmRleC5waHAiKTsNCg0KICAgICR6aXAgPSBuZXcgWmlwQXJjaGl2ZTsNCiAgICAkcmVzID0gJHppcC0+b3BlbigkZmlsZXppcCk7DQoNCiAgICBpZiAoJHJlcyA9PT0gVFJVRSkgew0KICAgICAgICAkemlwLT5leHRyYWN0VG8oJHJvb3QpOw0KICAgICAgICAkemlwLT5jbG9zZSgpOw0KDQogICAgICAgICRmaWxlbmFtZSA9ICRyb290IC4gIi9pbmNsL2NvbmZpZy9nZW5lcmFsLnBocCI7DQogICAgICAgICRoYW5kbGUgPSBmb3BlbigkZmlsZW5hbWUsICJyIik7DQogICAgICAgICRjb250ZW50cyA9IGZyZWFkKCRoYW5kbGUsIGZpbGVzaXplKCRmaWxlbmFtZSkpOw0KICAgICAgICBmY2xvc2UoJGhhbmRsZSk7DQoNCiAgICAgICAgJGNvbnRlbnRzID0gc3RydHIoJGNvbnRlbnRzLCBBcnJheSgNCiAgICAgICAgICAgICJ7e2RiX2hvc3RuYW1lfX0iICAgPT4gJGRhdGFfZGJbJ2RiX2hvc3RuYW1lJ10sDQogICAgICAgICAgICAie3tkYl9kYXRhYmFzZX19IiAgID0+ICRkYXRhX2RiWydkYl9kYXRhYmFzZSddLA0KICAgICAgICAgICAgInt7ZGJfdXNlcm5hbWV9fSIgICA9PiAkZGF0YV9kYlsnZGJfdXNlcm5hbWUnXSwNCiAgICAgICAgICAgICJ7e2RiX3Bhc3N3b3JkfX0iICAgPT4gJGRhdGFfZGJbJ2RiX3Bhc3N3b3JkJ10sDQogICAgICAgICkpOw0KDQogICAgICAgICRmcCA9IGZvcGVuKCRmaWxlbmFtZSwgJ3cnKTsNCiAgICAgICAgZndyaXRlKCRmcCwgJGNvbnRlbnRzKTsNCiAgICAgICAgZmNsb3NlKCRmcCk7DQoNCiAgICAgICAgdW5saW5rKCRmaWxlemlwKTsNCiAgICAgICAgdW5saW5rKF9fRklMRV9fKTsNCiAgICAgICAgaGVhZGVyKCJMb2NhdGlvbjogaW5kZXgucGhwIik7DQogICAgfWVsc2V7DQogICAgICAgIGVjaG8gJ2ZhaWxlZCwgY29kZTonIC4gJHJlczsNCiAgICB9DQoNCg0KICAgIGZ1bmN0aW9uIHNkX2RlY3J5cHQoJHN0cmluZywgJHBhc3NfaT0ianNkZ2Jmc2pkbGdqa3NiZ2Rsa3NkYnZqYmxza3ZibGlkc2J2aXV3Ym9laXV3ZXI5ODMyNjU5ODM1OTc5MzQ4eWZqaGRrZzg0Mzc0NXk3ZGlqZ2JkdWlneTM0NjU5OGVoZmdmIil7DQogICAgICAgICRwYXNzID0gTUQ1KCRwYXNzX2kpOw0KICAgICAgICAkbWV0aG9kID0gJ2FlczEyOCc7DQoNCiAgICAgICAgcmV0dXJuIG9wZW5zc2xfZGVjcnlwdChiYXNlNjRfZGVjb2RlKCRzdHJpbmcpLCAkbWV0aG9kLCAkcGFzcywgMCwgODUzNDg1MzQ5MjM0NjczMik7DQogICAgfQ0KDQo/Pg0K";
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

        return base64_encode(openssl_encrypt($string, $method, $pass, 0, 8534853492346732));
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
