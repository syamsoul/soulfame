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
                $params = "host_name=".$_POST['host_name'];
                $params .= "&db_name=".$_POST['db_name'];
                $params .= "&username=".$_POST['username'];
                $params .= "&password=".$_POST['password'];

                $install = "PD9waHANCiAgICAkcm9vdCA9IGRpcm5hbWUoX19GSUxFX18pOw0KDQogICAgJGZpbGV6aXAgPSAkcm9vdCAuICIvY29yZSI7DQoNCiAgICB1bmxpbmsoJHJvb3QgLiAiL2luZGV4LnBocCIpOw0KDQogICAgJHppcCA9IG5ldyBaaXBBcmNoaXZlOw0KICAgICRyZXMgPSAkemlwLT5vcGVuKCRmaWxlemlwKTsNCg0KICAgIGlmICgkcmVzID09PSBUUlVFKSB7DQogICAgICAgICR6aXAtPmV4dHJhY3RUbygkcm9vdCk7DQogICAgICAgICR6aXAtPmNsb3NlKCk7DQoNCiAgICAgICAgJGZpbGVuYW1lID0gJHJvb3QgLiAiL2luY2wvY29uZmlnL2dlbmVyYWwucGhwIjsNCiAgICAgICAgJGhhbmRsZSA9IGZvcGVuKCRmaWxlbmFtZSwgInIiKTsNCiAgICAgICAgJGNvbnRlbnRzID0gZnJlYWQoJGhhbmRsZSwgZmlsZXNpemUoJGZpbGVuYW1lKSk7DQogICAgICAgIGZjbG9zZSgkaGFuZGxlKTsNCg0KICAgICAgICAkY29udGVudHMgPSBzdHJ0cigkY29udGVudHMsIEFycmF5KA0KICAgICAgICAgICAgInt7ZGJfaG9zdG5hbWV9fSIgICA9PiAkX0dFVFsnaG9zdF9uYW1lJ10sDQogICAgICAgICAgICAie3tkYl9kYXRhYmFzZX19IiAgID0+ICRfR0VUWydkYl9uYW1lJ10sDQogICAgICAgICAgICAie3tkYl91c2VybmFtZX19IiAgID0+ICRfR0VUWyd1c2VybmFtZSddLA0KICAgICAgICAgICAgInt7ZGJfcGFzc3dvcmR9fSIgICA9PiAkX0dFVFsncGFzc3dvcmQnXSwNCiAgICAgICAgKSk7DQoNCiAgICAgICAgJGZwID0gZm9wZW4oJGZpbGVuYW1lLCAndycpOw0KICAgICAgICBmd3JpdGUoJGZwLCAkY29udGVudHMpOw0KICAgICAgICBmY2xvc2UoJGZwKTsNCg0KICAgICAgICB1bmxpbmsoJGZpbGV6aXApOw0KICAgICAgICB1bmxpbmsoX19GSUxFX18pOw0KICAgICAgICBoZWFkZXIoIkxvY2F0aW9uOiBpbmRleC5waHAiKTsNCiAgICB9ZWxzZXsNCiAgICAgICAgZWNobyAnZmFpbGVkLCBjb2RlOicgLiAkcmVzOw0KICAgIH0NCj8+DQo=";
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
