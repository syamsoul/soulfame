<?php
class SoulRoleModule{

    private $modules;


    function __construct(){
        $this->modules = Array();
    }


    public function check($mod_name, $arr_operator = "AND"){

        $mods = $this->modules;

        if(is_array($mods)){
            if(is_string($mod_name)){
                if(in_array($mod_name, $mods)) return true;
            }elseif(is_array($mod_name)){
                if($arr_operator == "AND"){
                    foreach($mod_name as $e_mod_name) if(!in_array($e_mod_name, $mods)) return false;
                    return true;
                }elseif($arr_operator == "OR"){
                    foreach($mod_name as $e_mod_name) if(in_array($e_mod_name, $mods)) return true;
                    return false;
                }
            }
        }

        return false;

    }


    public function add($mod_name){
        if(is_array($mod_name)) $this->modules = array_keys(array_merge(array_flip($this->modules), array_flip($mod_name)));
        elseif(is_string($mod_name)) array_push($this->modules, $mod_name);
    }

}
?>
