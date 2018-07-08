<?php

require_once dirname(__FILE__) . "/Encrypt.php";

class SoulAuth{

    private static $timeout; //seconds
    private static $db;
    private static $base_path;
    private static $encrypt;
    private static $instance;


    public static function init($conf_arr){

        if ( is_null( self::$instance ) ){
            if(!is_array($conf_arr)) die("ERROR: First argument in SoulAuth::init() must be an array.");
            if(empty($conf_arr['db'])) die("ERROR: DB instance must be included for SoulAuth.");

            self::$timeout      = !empty($conf_arr['timeout']) ? $conf_arr['timeout'] : 3600;
            self::$db           = $conf_arr['db'];
            self::$base_path    = $conf_arr['base_path'];

            $saltkey    = !empty($conf_arr['saltkey']) ? $conf_arr['saltkey'] : "defaultrandomkeyusedforencrypdata788567576";
            self::$encrypt  = new SoulEncrypt($saltkey);

            self::$instance = new self();
        }
        return self::$instance;

    }


    public static function login($uname, $pass){

        $db     = self::$db;
        $enc    = self::$encrypt;

        $user_data = $db->select("user", Array("id", "role_id"), Array(
            "user_name"    => $uname,
            "password"      => MD5($pass),
        ), 1, 1);

        if($user_data !== false){
            $session_id = session_id();
            $credential_str = $uname.$session_id.MD5($pass);

            $_COOKIE['sid']         = base64_encode($enc->encode($session_id));
            $_COOKIE['credential']  = base64_encode($enc->encode($credential_str));
            setcookie("sid", $_COOKIE['sid'], time() + self::$timeout, self::$base_path . "/");
            setcookie("credential", $_COOKIE['credential'], time() + self::$timeout, self::$base_path . "/");

            $_SESSION['credential'] = Array(
                "uname" => $uname,
                "upass" => MD5($pass),
                "sid"   => $session_id,
            );

            $_SESSION['user_profile'] = Array(
                "xid"           => $user_data['id'],
                "role_id"       => $user_data['role_id'],
            );

            return true;
        }

        return false;
    }


    public static function check(){

        $enc    = self::$encrypt;

        if(isset($_COOKIE['credential']) && !empty($_COOKIE['credential']) && isset($_SESSION['credential'])){
            $cred = $_SESSION['credential'];
            $credential_str = $cred['uname'].$cred['sid'].$cred['upass'];

            if(isset($_COOKIE['sid']) && isset($_COOKIE['credential'])){

                $is_correct_sid     = base64_encode($enc->encode($cred['sid'])) == $_COOKIE['sid'];
                $is_correct_cred    = base64_encode($enc->encode($credential_str)) == $_COOKIE['credential'];

                if($is_correct_sid && $is_correct_cred) {
                    setcookie("sid", $_COOKIE['sid'], time() + self::$timeout, self::$base_path . "/");
                    setcookie("credential", $_COOKIE['credential'], time() + self::$timeout, self::$base_path . "/");
                    return true;
                }

            }

            unset($_SESSION['credential']);
            setcookie("sid", "false", strtotime("-1 minute"), self::$base_path . "/");
            setcookie("credential", "false", strtotime("-1 minute"), self::$base_path . "/");
        }

        return false;

    }


    public static function logout(){

        session_start();
        setcookie("sid", $_COOKIE['sid'], strtotime("-1 minute"), self::$base_path . "/");
        setcookie("credential", $_COOKIE['credential'], strtotime("-1 minute"), self::$base_path . "/");
        session_unset();
        session_destroy();
        session_start();

    }

}
?>
