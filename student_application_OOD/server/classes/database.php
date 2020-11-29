<?php

class database {

    public $db_server;

    function __construct($db_hostname, $db_database, $db_username, $db_password) {
        $this->db_server = mysqli_connect($db_hostname, $db_username,$db_password,$db_database);
        if (!$this->db_server)
            die("Unable to connect to MySQL: " . mysqli_connect_errno());
    }

    function update($table, $values, $where) {
        $sql = "UPDATE $table SET ";

        if (count($values)) {
            $index = 0;
            foreach ($values as $key => $value) {
                if ($index > 0)
                    $sql.=" , ";
                $sql.="$key='$value' ";
                $index++;
            }
        }
        if ($where != "")
            $sql.="WHERE $where";


        $result = mysqli_query($this->db_server,$query);
        return $result;
    }

    function insert($table, $values) {
        $sql = "INSERT INTO " . $table . " ";

        if (count($values) > 0) {
            $sql.="(";
            $i = 0;
            foreach ($values as $key => $value) {
                if ($value != "" || $value != null) {
                    if ($i > 0)
                        $sql.=" , ";
                    $sql.=$key;
                    $i++;
                }
            }
            $sql.=") VALUES (";
            $i = 0;
            foreach ($values as $key => $value) {
                if ($value != "" || $value != null) {
                    if ($i > 0)
                        $sql.=" , ";
                    $sql.="'$value'";
                    $i++;
                }
            }
            $sql.=")";
        }
        $result = mysqli_query($this->db_server,$sql);
        return $result;
    }

    function select_like($table, $fields, $values) {
        $sql = "SELECT " . $fields . " FROM " . $table . " WHERE ";
        $i = 0;
        foreach ($values as $key => $value) {
            if ($i > 0)
                $sql.=" OR ";
            $sql.="$key LIKE '%$value%'";
            $i++;
        }

        $result = mysqli_query($this->db_server,$sql);
        return $result;
    }

    function select_like_SQL($table, $fields, $values) {
        $sql = "SELECT " . $fields . " FROM " . $table . " WHERE ";
        $i = 0;
        foreach ($values as $key => $value) {
            if ($i > 0)
                $sql.=" OR ";
            $sql.="$key LIKE '%$value%'";
            $i++;
        }
        
        $result = mysqli_query($this->db_server,$sql);
        return $result;
    }

    function inner_join_SQL($table1, $table2, $fields, $on, $where) {
        $sql = "SELECT " . $fields . " FROM " . $table1;
        $sql.=" INNER JOIN $table2 ON ";
        $sql.=$on;
        $sql.=" WHERE $where";
        
        $result = mysqli_query($this->db_server,$sql);
        return $result;
    }

    function union_SQL($sqls) {
        $final = "";
        $result = "";
        $i = 0;
        foreach ($sqls as $sql) {
            if ($i > 0)
                $final.=" UNION ";
            $final.=$sql;
            $i++;
        }

        return $final;
    }

    function union($sqls) {
        $final = "";
        $result = "";
        $i = 0;
        foreach ($sqls as $sql) {
            if ($i > 0)
                $final.=" UNION ";
            $final.=$sql;
            $i++;
        }
        if ($final != "") {
            $result = mysqli_query($this->db_server,$final);
        }
        return $result;
    }
    
    function delete_where($table,$where){
        $sql = "DELETE  FROM " . $table . " WHERE " . $where;
        $result = mysqli_query($this->db_server,$sql);
        return $result; 
    }

    function select_fields_where($table, $fields = "*", $where = "TRUE") {
        $sql = "SELECT " . $fields . " FROM " . $table . " WHERE " . $where;

        $result = mysqli_query($this->db_server,$sql);
        return $result;
    }

    function select_fields($table, $fields) {
        $sql = "SELECT " . $fields . " FROM " . $table;
        $result = mysqli_query($this->db_server,$sql);
        return $result;
    }

    function select_where_top($table, $top = 10, $where = "true") {
        //$result="called";
        $sql = "SELECT * FROM " . $table . " WHERE " . $where . " LIMIT $top";
        $result = mysqli_query($this->db_server,$sql);
        return $result;
    }

    function count($table) {
        $sql = "SELECT COUNT(*) As 'Count' FROM " . $table;
        $result = mysqli_query($this->db_server,$sql);

        while ($row = mysqli_fetch_array($this->db_server,$result)) {
            $count = $row["Count"];
        }
        return $count;
    }

    function select_where($table, $where) {
        //$result="called";
        $sql = "SELECT * FROM " . $table . " WHERE " . $where;
        $result = mysqli_query($this->db_server,$sql);
        return $result;
    }

    function general_query($SQL) {
        $result = mysqli_query($this->db_server,$SQL);
        return $result;
    }

    function LIKE_ALL_WORDS($field, &$values) {
        $LIKE = "";
        $index = 0;
        foreach ($values as $value) {
            if ($index != 0)
                $LIKE.=" OR ";
            $LIKE.="$field LIKE '%$value%' ";
            $index++;
        }
        return $LIKE;
    }

    function close() {
        mysqli_close($this->db_server);
    }

    function __destruct() {
        mysqli_close($this->db_server);
    }

}

?>
