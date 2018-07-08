<?php
    class SoulRoute{

        private $base_path;
        private $templ_folder;
        private $default_page;
        private $pages = Array();


        function __construct($base_path, $templ_dir){

            $this->base_path = $base_path;
            $this->templ_folder = $templ_dir;

        }


        public function setDefaultPage($str){

            $this->default_page = $str;

        }


        public function addPage($route_url, $templ_file){

            if(!empty($route_url) && !empty($templ_file)){

                $this->pages[$this->filter_url_route($route_url)] = $this->filter_url_route($templ_file);

            }else die("There's something wrong with route!");

        }


        public function executeRoute($current_page){

            $GLOBALS['_ROUTE'] = Array();

            $current_page       = $this->filter_url_route($current_page);
            $pages              = $this->pages;

            $current_page_arr = $this->get_url_level($current_page);

            foreach($pages as $route_url => $templ_file){

                $route_url_arr = $this->get_url_level($route_url);

                if(count($current_page_arr) == count($route_url_arr)){
                    $check_each = Array();

                    foreach($current_page_arr as $j=>$e_cpa){
                        $check_each[$j] = false;

                        if(isset($route_url_arr[$j])){
                            $is_url_var = $this->is_url_var($route_url_arr[$j]);
                            if(is_array($is_url_var) && $is_url_var['result']){
                                $GLOBALS['_ROUTE'][$is_url_var['var_name']] = $e_cpa;
                                $check_each[$j] = true;
                            }else{
                                if($route_url_arr[$j] == $e_cpa) $check_each[$j] = true;
                            }
                        }
                    }

                    if(!in_array(false, $check_each)) {
                        $filename = $this->templ_folder . "/" . $templ_file;
                        if(file_exists($filename)) return $filename;
                        else break;
                    }
                }
            }

            $def_page       = $this->filter_url_route($this->default_page);
            $def_page_x_get = explode("?", $def_page);
            $def_page_x_get = $def_page_x_get[0];

            if(!empty($pages[$def_page_x_get]) && file_exists($this->templ_folder . "/" . $pages[$def_page_x_get])) {
                if(isset($_REQUEST['action'])) die("ERROR: Session expired. Please refresh your browser");
                header("Location: ".$this->base_path."/".$def_page);
                return true;
            }
            return false;

        }


        public function filter_url_route($page_str){

        	while(substr($page_str, 0, 1) == "/") $page_str = substr($page_str." ", 1, -1);
        	while(substr($page_str, -1, 1) == "/") $page_str = substr($page_str, 0, -1);
        	return $page_str;

        }

        private function get_url_level($page_str){
            $page_str = $this->filter_url_route($page_str);
            $page_str = explode("/", $page_str);
            foreach($page_str as $i=>$e_ps) $page_str[$i] = trim($e_ps);
            return $page_str;
        }

        private function is_url_var($sub_page_str){
            $sub_page_str = trim($sub_page_str);

            $result = (substr($sub_page_str, 0, 1) == "{") && (substr($sub_page_str, -1, 1) == "}");

            $res = Array(
                "result"    => $result,
            );

            if($result) $res['var_name'] = substr($sub_page_str, 1, -1);

            return $res;
        }

    }
?>
