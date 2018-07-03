<?php
    class SoulCache{

        private $path;
        private $prefix = "";
        private $master_file = "masterinfo";


        function __construct($path, $prefix=null){

            $this->path = $path;
            $master_file_path = $path . "/" . md5($this->master_file);

            if(!empty($prefix)) $this->prefix = $prefix;

            if (!file_exists($path)) mkdir($path, 0777, true);
            if (!file_exists($master_file_path)){
                foreach(glob("$path/*") as $e_file) if($e_file != $master_file_path) unlink($e_file);
                $this->writeFile($master_file_path, base64_encode(json_encode(Array())));
            }else{
                $this->checkExpiry();
            }

        }


        public function set($name, $val, $timeout=120, $global=false){

            $path = $this->path;
            $master_file_path = $path . "/" . md5($this->master_file);

            if(!$global) $cache_name = md5($this->prefix.$name);
            else $cache_name = md5("global_".$name);

            $val = base64_encode($val);
            $this->writeFile($path . "/" . $cache_name, $val);

            $master_info = json_decode(base64_decode(file_get_contents($master_file_path)), true);
            $master_info[$cache_name] = Array(
                "created_at"    => time(),
                "timeout"       => $timeout,
            );
            $this->writeFile($master_file_path, base64_encode(json_encode($master_info)));

        }


        public function get($name, $global=false){

            if(!$global) $cache_name = md5($this->prefix.$name);
            else $cache_name = md5("global_".$name);

            $path_file = $this->path . "/" . $cache_name;

            if (file_exists($path_file)) return base64_decode(file_get_contents($path_file));
            return false;

        }


        public function getOrSet($name, $val_func, $timeout=120, $global=false){

            $current_data = $this->get($name, $global);
            if($current_data === false) {
                $current_data = $val_func();
                $this->set($name, $current_data, $timeout, $global);
            }
            return $current_data;

        }


        public function clear($name = null, $global=false){

            $path = $this->path;

            if(!empty($name)){
                $this->set($name, "" , 0, $global);
            }else array_map('unlink', glob("$path/*"));

        }


        public function checkExpiry(){

            $path = $this->path;

            if (!file_exists($path . "/" . md5($this->master_file))) return false;

            $master_info = json_decode(base64_decode(file_get_contents($path . "/" .  md5($this->master_file))), true);

            $file_list_recorded = array_keys($master_info);
            $file_list_real     = glob("$path/*");

            foreach($file_list_real as $file){
                $temp_file = explode("/", $file);
                $temp_file = $temp_file[count($temp_file)-1];

                if($temp_file != md5($this->master_file)){

                    if(in_array($temp_file, $file_list_recorded)){

                        $timeout    = $master_info[$temp_file]["timeout"];
                        $created_at = $master_info[$temp_file]["created_at"];

                        if((time() - $created_at) >= $timeout) unlink($file);

                    }else unlink($file);

                }
            }

        }


        public function setPrefix($prefix){

            if(!empty($prefix)) $this->prefix = $prefix;

        }


        private function writeFile($name, $val){

            $fhandle = fopen($name, "w");
            fwrite($fhandle, $val);
            fclose($fhandle);

        }


    }
?>
