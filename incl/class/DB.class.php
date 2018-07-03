<?php
//$db = Database::obtain(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);

//$db = Database::obtain();

class Database
{
    private $conn = null;
    private $config = Array();
    private $debug = false;

    function __construct($hostname, $username, $password, $db_name){
        $this->config['HOSTNAME'] = $hostname;
        $this->config['USERNAME'] = $username;
        $this->config['PASSWORD'] = $password;
        $this->config['DATABASE'] = $db_name;

        $this->connect();

        return $this;
    }

    public function connect(){
        $config = $this->config;
        $this->conn = @mysqli_connect($config['HOSTNAME'], $config['USERNAME'], $config['PASSWORD'], $config['DATABASE']);

        // Check connection
        if (mysqli_connect_errno()){
            die("Failed to connect to MySQL: " . mysqli_connect_error());
        }
    }

    public function disconnect(){
        mysqli_close($this->conn);
    }

    public function query($sql_str){
        $con = $this->conn;

        if( !($result = mysqli_query($con, $sql_str)) ) {
            echo "ERROR: Something wrong's while processing MYSQL query";
            if($this->debug) echo ": " . mysqli_error($con);
            exit();
            return false;
        }
        return $result;
    }

    public function query_select($sql_str, $which_row=null){
        $sql = $this->query($sql_str);
        $result = Array();
        while($each_row = mysqli_fetch_assoc($sql)){
            array_push($result, $each_row);
        }
        if(!empty($which_row) && is_numeric($which_row)) return isset($result[$which_row-1])?$result[$which_row-1]:false;
        return $result;
    }

    public function select($table_name, $col=null, $cond=null, $limit=null, $which_row=null){

        if($col == null ) $query = "SELECT * FROM `$table_name`";
        elseif(is_array($col)) $query = "SELECT `".implode("`,`", $col)."` FROM `$table_name`";

        if(!empty($cond)){

            $query .= " WHERE ";
            if(is_string($cond)){
                $query .= $cond;
            }elseif(is_array($cond)){
                foreach($cond as $col_name => $row_data) {
                    $row_data = $this->escape($row_data);

                    if(strtolower($row_data) === "null"){
                        $query .= "`$col_name` IS NULL";
                    }elseif(strtolower($row_data) === "!null"){
                        $query .= "`$col_name` IS NOT NULL";
                    }else{
                        $list_val_without_quote = Array("now()");
                        if(in_array(strtolower($row_data), $list_val_without_quote)) $str_quote = "";
                        else $str_quote = "'";

                        $query .= "`$col_name`";
                        $query .= "=";
                        $query .= $this->filter_mysql_func($str_quote.$row_data.$str_quote);
                    }
                    $query .= " AND ";
                }
                $query = substr(trim($query), 0, -3);
            }
        }

        $query = trim($query);

        if(!empty($limit)) $query .= " LIMIT $limit";

        $sql = $this->query($query);

        $result = Array();
        while($each_row = mysqli_fetch_assoc($sql)){
            array_push($result, $each_row);
        }
        if(!empty($which_row) && is_numeric($which_row)) return isset($result[$which_row-1])?$result[$which_row-1]:false;
        return $result;
    }

    public function insert($table_name, $data){
        $query = "INSERT INTO `$table_name` ";
        $query_col_name = Array(); $query_row_data = Array();
        foreach($data as $col_name => $row_data) {
            $row_data = $this->escape($row_data);

            array_push($query_col_name, '`'.$col_name.'`');
            array_push($query_row_data, $this->filter_mysql_func("'".$row_data."'"));
        }
        $query = $query
                . "(".implode(",",$query_col_name).")"
                . " VALUES "
                . "(".implode(",",$query_row_data).")";
        $sql = $this->query($query);

        return mysqli_insert_id($this->conn);
    }

    public function update($table_name, $data, $cond=null){
        $query = "UPDATE `$table_name` SET ";

        foreach($data as $col_name => $row_data) {
            $row_data = $this->escape($row_data);

            $query .= "`$col_name`";
            $query .= "=";
            $query .= $this->filter_mysql_func("'".$row_data."'");
            $query .= ", ";
        }
        $query = substr(trim($query), 0, -1);

        if(!empty($cond)){

            $query .= " WHERE ";
            if(is_string($cond)){
                $query .= $cond;
            }elseif(is_array($cond)){
                foreach($cond as $col_name => $row_data) {
                    $row_data = $this->escape($row_data);

                    if(strtolower($row_data) === "null"){
                        $query .= "`$col_name` IS NULL";
                    }elseif(strtolower($row_data) === "!null"){
                        $query .= "`$col_name` IS NOT NULL";
                    }else{
                        $query .= "`$col_name`";
                        $query .= "=";
                        $query .= $this->filter_mysql_func("'".$row_data."'");
                    }
                    $query .= " AND ";
                }
                $query = substr(trim($query), 0, -3);
            }
        }

        $query = trim($query);

        $sql = $this->query($query);

        return $sql;
    }

    public function delete($table_name, $cond){

        if(empty($cond)) return false;

        $query = "DELETE FROM `$table_name` WHERE ";
        if(is_string($cond)){
            $query .= $cond;
        }elseif(is_array($cond)){
            foreach($cond as $col_name => $row_data) {
                $row_data = $this->escape($row_data);

                if(strtolower($row_data) === "null"){
                    $query .= "`$col_name` IS NULL";
                }elseif(strtolower($row_data) === "!null"){
                    $query .= "`$col_name` IS NOT NULL";
                }else{
                    $query .= "`$col_name`";
                    $query .= "=";
                    $query .= $this->filter_mysql_func("'".$row_data."'");
                }
                $query .= " AND ";
            }
            $query = substr(trim($query), 0, -3);
        }

        $sql = $this->query($query);

        return $sql;

    }

    public function escape($string){
        return mysqli_real_escape_string($this->conn, $string);
    }

    private function filter_mysql_func($string){
        $cond_repl = Array(
            "'now()'"   => "NOW()",
            "'null'"   => "NULL",
        );
        if(in_array(strtolower($string), array_keys($cond_repl))) $string = strtolower($string);
        return strtr($string, $cond_repl);
    }

    public function enableDebug($opt){
        if(!is_bool($opt)) die("ERROR: Problem when enabling debug mode");
        $this->debug = $opt;

        return $this;
    }

}

?>
