<?php
    if(!file_exists(dirname(__FILE__) . "/core")) die("ERROR: No core file");

    if(empty($_POST['dbregBtn'])){
        $show_form = true;
        $def_host_name  = "";
        $def_db_name    = "";
        $def_username   = "";
    }else{
        $conn = @mysqli_connect($_POST['host_name'], $_POST['username'], $_POST['password'], $_POST['db_name']);
        $is_db_conn_failed = mysqli_connect_errno();

        if($is_db_conn_failed){
            $show_form = true;
            $def_host_name  = $_POST['host_name'];
            $def_db_name    = $_POST['db_name'];
            $def_username   = $_POST['username'];
        }else $show_form = false;
    }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title></title>
    </head>
    <body>
        <?php if($show_form): ?>
            <link href='http://fonts.googleapis.com/css?family=Bitter' rel='stylesheet' type='text/css'>
            <style type="text/css">
            body{
                font-family: 'Bitter', sans-serif !important;
            }
            .form-style-10{
                width:450px;
                padding:30px;
                margin:40px auto;
                background: #FFF;
                border-radius: 10px;
                -webkit-border-radius:10px;
                -moz-border-radius: 10px;
                box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.13);
                -moz-box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.13);
                -webkit-box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.13);
            }
            .form-style-10 .inner-wrap{
                padding: 30px;
                background: #F8F8F8;
                border-radius: 6px;
                margin-bottom: 15px;
            }
            .form-style-10 h1{
                background: #2A88AD;
                padding: 20px 30px 15px 30px;
                margin: -30px -30px 30px -30px;
                border-radius: 10px 10px 0 0;
                -webkit-border-radius: 10px 10px 0 0;
                -moz-border-radius: 10px 10px 0 0;
                color: #fff;
                text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.12);
                font: normal 30px 'Bitter', serif;
                -moz-box-shadow: inset 0px 2px 2px 0px rgba(255, 255, 255, 0.17);
                -webkit-box-shadow: inset 0px 2px 2px 0px rgba(255, 255, 255, 0.17);
                box-shadow: inset 0px 2px 2px 0px rgba(255, 255, 255, 0.17);
                border: 1px solid #257C9E;
            }
            .form-style-10 h1 > span{
                display: block;
                margin-top: 2px;
                font: 13px Arial, Helvetica, sans-serif;
            }
            .form-style-10 label{
                display: block;
                font: 13px Arial, Helvetica, sans-serif;
                color: #888;
                margin-bottom: 15px;
            }
            .form-style-10 input[type="text"],
            .form-style-10 input[type="date"],
            .form-style-10 input[type="datetime"],
            .form-style-10 input[type="email"],
            .form-style-10 input[type="number"],
            .form-style-10 input[type="search"],
            .form-style-10 input[type="time"],
            .form-style-10 input[type="url"],
            .form-style-10 input[type="password"],
            .form-style-10 textarea,
            .form-style-10 select {
                display: block;
                box-sizing: border-box;
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                width: 100%;
                padding: 8px;
                border-radius: 6px;
                -webkit-border-radius:6px;
                -moz-border-radius:6px;
                border: 2px solid #fff;
                box-shadow: inset 0px 1px 1px rgba(0, 0, 0, 0.33);
                -moz-box-shadow: inset 0px 1px 1px rgba(0, 0, 0, 0.33);
                -webkit-box-shadow: inset 0px 1px 1px rgba(0, 0, 0, 0.33);
            }

            .form-style-10 .section{
                font: normal 20px 'Bitter', serif;
                color: #2A88AD;
                margin-bottom: 5px;
            }
            .form-style-10 .section span {
                background: #2A88AD;
                padding: 5px 10px 5px 10px;
                position: absolute;
                border-radius: 50%;
                -webkit-border-radius: 50%;
                -moz-border-radius: 50%;
                border: 4px solid #fff;
                font-size: 14px;
                margin-left: -45px;
                color: #fff;
                margin-top: -3px;
            }
            .form-style-10 input[type="button"],
            .form-style-10 button{
                background: #2A88AD;
                padding: 8px 20px 8px 20px;
                border-radius: 5px;
                -webkit-border-radius: 5px;
                -moz-border-radius: 5px;
                color: #fff;
                text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.12);
                font: normal 30px 'Bitter', serif;
                -moz-box-shadow: inset 0px 2px 2px 0px rgba(255, 255, 255, 0.17);
                -webkit-box-shadow: inset 0px 2px 2px 0px rgba(255, 255, 255, 0.17);
                box-shadow: inset 0px 2px 2px 0px rgba(255, 255, 255, 0.17);
                border: 1px solid #257C9E;
                font-size: 15px;
            }
            .form-style-10 input[type="button"]:hover,
            .form-style-10 button:hover{
                background: #2A6881;
                -moz-box-shadow: inset 0px 2px 2px 0px rgba(255, 255, 255, 0.28);
                -webkit-box-shadow: inset 0px 2px 2px 0px rgba(255, 255, 255, 0.28);
                box-shadow: inset 0px 2px 2px 0px rgba(255, 255, 255, 0.28);
            }
            .form-style-10 .privacy-policy{
                float: right;
                width: 250px;
                font: 12px Arial, Helvetica, sans-serif;
                color: #4D4D4D;
                margin-top: 10px;
                text-align: right;
            }
            </style>
            <div class="form-style-10">
                <h1 style="text-align:center;">SoulFame<span>Please enter the application details to procceed</span></h1>
                <form action="" method="POST">
                    <div class="section"><span>1</span>MySQL Database</div>
                    <div class="inner-wrap">
                        <label>Host Name <input type="text" name="host_name" value="<?=$def_host_name?>"/></label>
                        <label>Database Name <input type="text" name="db_name" value="<?=$def_db_name?>"/></label>
                        <label>Username <input type="text" name="username" value="<?=$def_username?>"/></label>
                        <label>Password <input type="password" name="password" /></label>
                        <?= ((isset($is_db_conn_failed) && $is_db_conn_failed) ? "<div style=\"color:red;\">ERROR: Failed to connect to MySQL: " . mysqli_connect_error() . "</div>" : "") ?>
                    </div>

                    <div class="button-section">
                        <button type="submit" name="dbregBtn" value="true">Procceed</button>
                        <span class="privacy-policy" style="display:none;">
                            <input type="checkbox" name="field7">You agree to our Terms and Policy.
                        </span>
                    </div>
                </form>
            </div>
        <?php endif; ?>

        <?php if(!empty($_POST['dbregBtn'])){
            if(!$is_db_conn_failed){
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
                <style media="screen">
                body{
                    font-family: 'Raleway', sans-serif !important;
                }
                .sk-folding-cube {
                margin: 20px auto;
                width: 40px;
                height: 40px;
                position: relative;
                -webkit-transform: rotateZ(45deg);
                      transform: rotateZ(45deg);
                }

                .sk-folding-cube .sk-cube {
                float: left;
                width: 50%;
                height: 50%;
                position: relative;
                -webkit-transform: scale(1.1);
                  -ms-transform: scale(1.1);
                      transform: scale(1.1);
                }
                .sk-folding-cube .sk-cube:before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: #333;
                -webkit-animation: sk-foldCubeAngle 2.4s infinite linear both;
                      animation: sk-foldCubeAngle 2.4s infinite linear both;
                -webkit-transform-origin: 100% 100%;
                  -ms-transform-origin: 100% 100%;
                      transform-origin: 100% 100%;
                }
                .sk-folding-cube .sk-cube2 {
                -webkit-transform: scale(1.1) rotateZ(90deg);
                      transform: scale(1.1) rotateZ(90deg);
                }
                .sk-folding-cube .sk-cube3 {
                -webkit-transform: scale(1.1) rotateZ(180deg);
                      transform: scale(1.1) rotateZ(180deg);
                }
                .sk-folding-cube .sk-cube4 {
                -webkit-transform: scale(1.1) rotateZ(270deg);
                      transform: scale(1.1) rotateZ(270deg);
                }
                .sk-folding-cube .sk-cube2:before {
                -webkit-animation-delay: 0.3s;
                      animation-delay: 0.3s;
                }
                .sk-folding-cube .sk-cube3:before {
                -webkit-animation-delay: 0.6s;
                      animation-delay: 0.6s;
                }
                .sk-folding-cube .sk-cube4:before {
                -webkit-animation-delay: 0.9s;
                      animation-delay: 0.9s;
                }
                @-webkit-keyframes sk-foldCubeAngle {
                    0%, 10% {
                    -webkit-transform: perspective(140px) rotateX(-180deg);
                            transform: perspective(140px) rotateX(-180deg);
                    opacity: 0;
                    } 25%, 75% {
                    -webkit-transform: perspective(140px) rotateX(0deg);
                            transform: perspective(140px) rotateX(0deg);
                    opacity: 1;
                    } 90%, 100% {
                    -webkit-transform: perspective(140px) rotateY(180deg);
                            transform: perspective(140px) rotateY(180deg);
                    opacity: 0;
                    }
                }

                @keyframes sk-foldCubeAngle {
                    0%, 10% {
                    -webkit-transform: perspective(140px) rotateX(-180deg);
                            transform: perspective(140px) rotateX(-180deg);
                    opacity: 0;
                    } 25%, 75% {
                    -webkit-transform: perspective(140px) rotateX(0deg);
                            transform: perspective(140px) rotateX(0deg);
                    opacity: 1;
                    } 90%, 100% {
                    -webkit-transform: perspective(140px) rotateY(180deg);
                            transform: perspective(140px) rotateY(180deg);
                    opacity: 0;
                    }
                }
                </style>
                <div style="position:fixed;top:0;bottom:0;left:0;right:0;">
            		<div style="display:table;height:100%;width:100%;">
            			<div style="display:table-cell;vertical-align:middle;text-align:center;">
            				<div style="font-size: 2.15em;padding-bottom: 20px;">Installing</div>
            				<div class="sk-folding-cube">
            					<div class="sk-cube1 sk-cube"></div>
            					<div class="sk-cube2 sk-cube"></div>
            					<div class="sk-cube4 sk-cube"></div>
            					<div class="sk-cube3 sk-cube"></div>
            				</div>
            				<div style="font-size: 1.55em;">Please wait</div>
            			</div>
            		</div>
            	</div>

                <script type="text/javascript">
                    setTimeout(function(){
                        window.location.href = "install.php?<?=$params?>";
                    },1500);
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
