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

            $current_page       = $this->filter_url_route($current_page);
            $pages              = $this->pages;

            foreach($pages as $route_url => $templ_file){
                if($current_page == $route_url){
                    $filename = $this->templ_folder . "/" . $templ_file;
                    if(file_exists($filename)) return $filename;
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

    }
?>
