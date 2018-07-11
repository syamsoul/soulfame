<?php
    //custom function below:
    function getRoleModuleCache(){
        global $db, $cache;

        $roleModules = $cache->getOrSet("roleModules", function() use($db){
            $roles = $db->select("role", Array("id", "modules"));
            $result = Array();
            foreach($roles as $role){
                if(!empty($role['modules'])){
                    $temp_mod = $db->query_select("SELECT `module_name` FROM `module` WHERE `id` IN (".$role['modules'].")");
                    $temp_mod = array_column($temp_mod, 'module_name');
                }else $temp_mod = Array();
                $result[$role['id']] = $temp_mod;
            }
            return json_encode($result);
        }, strtotime("+8 hour")-time(), true);
        $roleModules = json_decode($roleModules, true);

        return $roleModules;
    }

    function getRolesCache($show_all=false){
        global $db, $cache, $module;

        $cache_timeout = "+8 hour";

        $groups = $cache->getOrSet("groups", function() use($db){
            $result = $db->select("group");
            $result =  array_combine(array_column($result, 'id'), array_column($result, 'group_name'));

            return json_encode($result);
        }, strtotime($cache_timeout)-time());
        $groups = json_decode($groups, true);

        $roles = $cache->getOrSet("roles", function() use($db, $module, $groups){
            $roles = $db->query_select("SELECT * FROM `role` ORDER BY `order_no` DESC");

            return json_encode($roles);
        }, strtotime($cache_timeout)-time());
        $roles = json_decode($roles, true);


        $roles_new = Array();

        foreach($roles as $i=>$role){
            $rid = $role['id'];
            $rname = $role['role_name'];

            if($show_all === false){
                if($rid == 1 && !$module->check("Admin -> Manage -> Manage Superadmin")) continue;
                if($rid == 5 && !$module->check("Admin -> Manage -> Manage Second Admin")) continue;
                if($rid == 6 && !$module->check("Admin -> Manage -> Manage Pengerusi")) continue;
                if($rid == 7 && !$module->check("Admin -> Manage -> Manage Bendahari")) continue;
                if($rid == 8 && !$module->check("Admin -> Manage -> Manage Setiausaha")) continue;
                if($rid == 2 && !$module->check("Admin -> Manage -> Manage State Admin")) continue;
                if($rid == 3 && !$module->check("Admin -> Manage -> Manage City Admin")) continue;
                if($rid == 4 && !$module->check("Admin -> Manage -> Manage Continent Admin")) continue;
            }

            if(!empty($role['group']) && is_numeric($role['group'])) {
                $gid = "group_".$role['group'];

                if(!isset($roles_new[$gid])){
                    $roles_new[$gid] = Array(
                        "group_name" => $groups[$role['group']],
                        "sub_role"  => Array($rid=>$rname)
                    );
                }else{
                    $roles_new[$gid]['sub_role'][$rid] = $rname;
                }
            }else $roles_new[$rid] = $rname;
        }

        return $roles_new;
    }

    function getAllRoleName($show_all=false, $return_arr=true){
        $roles = getRolesCache($show_all);

        $result = Array();

        foreach($roles as $id=>$role){
            if(is_numeric($id) && is_string($role)){
                if($return_arr === false) $result[$id] = $role;
                else $result[$id] = Array(
                    "name"  => $role,
                );
            }elseif(isset($role['sub_role'])){
                foreach($role['sub_role'] as $e_r_id=>$e_r_name){
                    if($return_arr === false) $result[$e_r_id] = $role['group_name'] . " (".$e_r_name.")";
                    else $result[$e_r_id] = Array(
                        "name"          => $e_r_name,
                        "group_name"    => $role['group_name']
                    );
                }
            }
        }

        return ((!empty($result)) ? $result : false);

    }

    function getRoleName($rid, $show_all=false, $return_arr=true){
        $roles = getRolesCache($show_all);

        $result = Array();

        if(is_array($rid)){
            foreach($rid as $i=>$e_rid){
                foreach($roles as $id=>$role){
                    if(is_numeric($id) && is_string($role)){
                        if($id == $e_rid) {
                            if($return_arr === false) $result[$e_rid] = $role;
                            else $result[$e_rid] = Array(
                                "name"  => $role,
                            );
                            break;
                        }
                    }elseif(isset($role['sub_role'])){
                        $sub_role = array_keys($role['sub_role']);
                        if(in_array($e_rid, $sub_role)){
                            if($return_arr === false) $result[$e_rid] = $role['group_name'] . " (".$role['sub_role'][$e_rid].")";
                            else $result[$e_rid] = Array(
                                "name"          => $role['sub_role'][$e_rid],
                                "group_name"    => $role['group_name']
                            );
                            break;
                        }
                    }
                }
            }
        }elseif(is_numeric($rid)){
            foreach($roles as $id=>$role){
                if(is_numeric($id) && is_string($role)){
                    if($id == $rid) {
                        if($return_arr === false) $result[$e_rid] = $role;
                        else $result['name'] = $role;
                        break;
                    }
                }elseif(isset($role['sub_role'])){
                    $sub_role = array_keys($role['sub_role']);
                    if(in_array($rid, $sub_role)){
                        if($return_arr === false) $result = $role['group_name'] . " (".$role['sub_role'][$e_rid].")";
                        else $result = Array(
                            "name"          => $role['sub_role'][$rid],
                            "group_name"    => $role['group_name']
                        );
                        break;
                    }
                }
            }
        }

        return ((!empty($result)) ? $result : false);
    }

    function getRoleIdByModule($mod_name, $json=false){

        $role_mod = getRoleModuleCache();
        $result = Array();

        if(is_string($mod_name)){
            $result = sub_array_search($mod_name, $role_mod);
        }elseif(is_array($mod_name)){
            foreach($mod_name as $e_mn) $result = array_merge($result, sub_array_search($e_mn, $role_mod));
        }

        if($json) return json_encode($result);
        return $result;
    }



    function sendNoti($title, $desc, $aid){
        global $db;

        $noti_res = $db->insert("notification", Array(
            "title"     => $title,
            "desc"      => $desc,
            "admin_id"  => $aid,
        ));
        if(!empty($noti_res)) {
            refreshNoti($aid);
            return true;
        }

        return false;
    }

    function refreshNoti($aid){
        global $encrypt;

        require APP_ROOT_DIR . '/incl/class/pusher/vendor/autoload.php';

        $options = array(
            'cluster' => 'ap1',
            'encrypted' => true
        );

        $pusher = new Pusher\Pusher(
            'eb87a682dc88e1114748',
            'e763da7bde463069a5bc',
            '521964',
            $options
        );

        $data['message'] = 'new noti';
        $pusher->trigger($encrypt->encode(APP_ROOT_DIR), 'newnoti-'.$encrypt->encode(date("Ym").(date("d")*$aid).$aid), $data);
    }
?>
