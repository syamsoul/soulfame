<?php
class SoulNav{

    private static $menu        = Array();
    private static $activeNav   = false;

    private $currentmenu;


    function __construct($currentmenu=null){
        if(!empty($currentmenu)) $this->currentmenu = $currentmenu;
    }


    public function addMenu($label, $redirect_url="submenu", $extra_data=null){

        $thisinstance = $this;

        if(is_array($redirect_url)) {
            $redirect_url   = "submenu";
            $extra_data     = $redirect_url;
        }

        if(!empty($label) && !empty($redirect_url)){

            $is_has_sub = $redirect_url == "submenu" || is_callable($redirect_url);

            $temp_menu_arr = Array(self::$menu);
            $temp_menu = self::$menu;

            if(!empty($this->currentmenu)){
                $currmenu_arr = explode(",", $this->currentmenu);

                foreach($currmenu_arr as $indexkey=>$e_currmenu){
                    if($indexkey == 0 ) $temp_menu = self::$menu[$e_currmenu]['sub_menu'];
                    else $temp_menu = $temp_menu[$e_currmenu]["sub_menu"];
                    array_push($temp_menu_arr, $temp_menu);
                }
            }

            $temp_menu = $temp_menu_arr[count($temp_menu_arr)-1];

            $default_val = Array(
                "label"     => $label,
                "is_active" => false,
                "extra"     => $extra_data,
            );

            if($is_has_sub){

                array_push($temp_menu, $default_val + Array(
                    "has_sub"   => true,
                    "sub_menu"  => Array(),
                ));

            }else{

                array_push($temp_menu, $default_val + Array(
                    "has_sub"   => false,
                    "redirect"  => $this->filter_url_route($redirect_url),
                ));

            }

            $currentmenu_index = empty($this->currentmenu) ? (count($temp_menu) - 1) : $this->currentmenu . "," . (count($temp_menu) - 1);

            $temp_menu_arr[count($temp_menu_arr)-1] = $temp_menu;

            foreach(array_reverse($temp_menu_arr) as $e_key=>$e_menu){
                if($e_key == count($temp_menu_arr)-1) self::$menu = $temp_menu_arr[0];
                else $temp_menu_arr[count($temp_menu_arr)-1-($e_key+1)][$currmenu_arr[count($currmenu_arr)-($e_key+1)]]['sub_menu'] = $temp_menu_arr[count($temp_menu_arr)-($e_key+1)];
            }

            if($is_has_sub) {
                if(is_callable($redirect_url)) $redirect_url(new $thisinstance($currentmenu_index));
                return new $thisinstance($currentmenu_index);
            }

            return true;

        }

        return false;

    }


    public function getNav(){
        return self::$menu;
    }


    public function getNavString($no_sub_li, $has_sub_li, $menu_list=null){
        if(!is_callable($no_sub_li) || !is_callable($has_sub_li)) die("ERROR: Something's wrong");

        $string = "";

        if($menu_list == null) $menu_list = self::$menu;

        foreach($menu_list as $index => $e_menu){
            if(!$e_menu['has_sub']) $string .= $no_sub_li($e_menu);
            else {
                if(empty($e_menu['sub_menu'])) continue;
                $sub_menu = $this->getNavString($no_sub_li, $has_sub_li, $e_menu['sub_menu']);
                $e_menu["uniqid"] = "nav_submenu_" . $index . date("His");
                $string .= $has_sub_li($e_menu, $sub_menu);
            }
        }

        return $string;
    }


    public function checkActiveNav($current_page, $parent_active = false){
        $current_page = $this->filter_url_route($current_page);

        foreach(self::$menu as $key=>$e_page){
            $this->checkEachSub($current_page, $key, $e_page);
        }

        if(self::$activeNav !== false){
            $tempnav_arr = Array();
            $activeNav_arr = explode(",", self::$activeNav);
            foreach($activeNav_arr as $i=>$ekey) {
                if($i == 0) $currentNav = self::$menu[$ekey];
                else $currentNav = $currentNav["sub_menu"][$ekey];
                array_push($tempnav_arr, $currentNav);
                if($parent_active) $tempnav_arr[count($tempnav_arr)-1]['is_active'] = true;
            }
            if(!$parent_active) $tempnav_arr[count($tempnav_arr)-1]['is_active'] = true;

            foreach(array_reverse($tempnav_arr) as $e_key=>$e_menu){
                if($e_key == count($tempnav_arr)-1) self::$menu[$activeNav_arr[0]] = $tempnav_arr[0];
                else $tempnav_arr[count($tempnav_arr)-1-($e_key+1)]['sub_menu'][$activeNav_arr[count($activeNav_arr)-($e_key+1)]] = $tempnav_arr[count($tempnav_arr)-($e_key+1)];
            }
        }
    }


    private function checkEachSub($current_page, $currentkey, $e_page){
        if(!empty(self::$activeNav)) return true;

        if($e_page['has_sub']) foreach($e_page['sub_menu'] as $key2=>$e_page2){
            $this->checkEachSub($current_page, ($currentkey.",".$key2), $e_page2);
        }else if($e_page['redirect'] == $current_page) self::$activeNav = $currentkey;
    }


    private function filter_url_route($page_str){

        while(substr($page_str, 0, 1) == "/") $page_str = substr($page_str." ", 1, -1);
        while(substr($page_str, -1, 1) == "/") $page_str = substr($page_str, 0, -1);
        return $page_str;

    }

}

?>
