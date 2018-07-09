<?php
    session_start();

    require_once APP_ROOT_DIR . "/incl/config/general.php";
    require_once APP_ROOT_DIR . "/incl/class/DB.class.php";
    require_once APP_ROOT_DIR . "/incl/class/Cache.php";
    require_once APP_ROOT_DIR . "/incl/class/Encrypt.php";
    require_once APP_ROOT_DIR . "/incl/class/Auth.php";
    require_once APP_ROOT_DIR . "/incl/class/RoleModule.php";
    require_once APP_ROOT_DIR . "/incl/class/Route.php";
    require_once APP_ROOT_DIR . "/incl/class/Nav.php";
    require_once APP_ROOT_DIR . "/incl/class/function.php";

	define("URL_HTTP_HOST", $_SERVER["REQUEST_SCHEME"]."://".$_SERVER["HTTP_HOST"]);
    define("URL_BASE_PATH", get_url_base_path());

    $db     = (new Database($db_conf['HOSTNAME'], $db_conf['USERNAME'], $db_conf['PASSWORD'], $db_conf['DATABASE']))->enableDebug(DB_DEBUG_ENABLE);
    $cache  = new SoulCache(APP_ROOT_DIR . "/temp/cache");
    $auth   = SoulAuth::init(Array(
        "db"        => $db,
        "base_path" => URL_BASE_PATH,
        "timeout"   => 3600,
        "saltkey"   => $saltkeys['user'],
    ));
    $encrypt = new SoulEncrypt($saltkeys['main']);
    $module = new SoulRoleModule();

    if(!empty($_POST['logoutBtn'])){
        $auth->logout();
    }


    $authenticated_user = false;

    if(!empty($_POST['loginBtn'])){

        $authenticated_user = $auth->login($_POST['username'], $_POST['password']);

    }else{

        $authenticated_user = $auth->check();

    }

    if($authenticated_user){

        $cache->setPrefix($_SESSION['user_profile']['xid'].$_SESSION['user_profile']['role_id'].$_SESSION['credential']['uname']."_");

        $role_modules = getRoleModuleCache();
        $the_modules = sd_default(@$role_modules[$_SESSION['user_profile']['role_id']], Array());
        $module->add($the_modules);

        define("USER_ROOT_ALL_PATH", APP_ROOT_DIR . "/incl/storage/user");
        define("USER_ROOT_PATH", USER_ROOT_ALL_PATH."/".$_SESSION['user_profile']['xid']);
        define("USER_ROOT_PUBLIC_PATH", USER_ROOT_PATH."/public");

        if(!is_dir(USER_ROOT_ALL_PATH)) mkdir(USER_ROOT_ALL_PATH, 0755, true);
        if(!is_dir(USER_ROOT_PATH)) mkdir(USER_ROOT_PATH, 0777, true);
        if(!is_dir(USER_ROOT_PUBLIC_PATH)) mkdir(USER_ROOT_PUBLIC_PATH, 0755, true);

    }

    define("TEMPLATE_DIR", APP_ROOT_DIR . "/incl/templ");
    define("IMG_STORAGE_PATH", APP_ROOT_DIR . "/incl/storage/image");

    if(!is_dir(TEMPLATE_DIR)) mkdir(TEMPLATE_DIR, 0755, true);
    if(!is_dir(IMG_STORAGE_PATH)) mkdir(IMG_STORAGE_PATH, 0755, true);
    
    $pages      = new SoulRoute(URL_BASE_PATH, TEMPLATE_DIR);
    $navmenu    = new SoulNav();

    //custom temporary
    $enable_ajax = false;
?>
