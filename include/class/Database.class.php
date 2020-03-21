<?php

class Database extends mysqli
{
    public function __construct($host, $user, $password, $database) {
        parent::__construct($host, $user, $password, $database);

        if (mysqli_connect_error()) {
            die('Connect Error (' . mysqli_connect_errno() . ') '
                . mysqli_connect_error());
        }
    }

    public function InsertRow($db, $table, $data_array, $debug=false) {
        $cols = '';
        $vals = '';
        foreach ($data_array as $column => $value) {
            $cols .= $this->res($column) . ', ';

            if ($value === 'NOW()') {
                $vals .= 'NOW(), ';
            }
            else {
                $vals .= "'".$this->res($value)."', ";
            }
        }
        $cols = rtrim($cols, ', ');
        $vals = rtrim($vals, ', ');

        $sql = "INSERT INTO $db.$table (".$cols.") VALUES (".$vals.");";
        if ($debug) {
            echo $sql;
            return false;
        }
        else $this->query($sql);

        if ($this->insert_id === 0) return false;
        else return $this->insert_id;
    }

    public function UpdateRow($db, $table, $id, $data_array, $debug=false) {
        $sql = "UPDATE $db.$table SET ";
        foreach ($data_array as $column => $value) {
            $sql .= $this->res($column);
            $sql .= ' = ';
            if ($value === 'NOW()') {
                $sql .= 'NOW()';
            }
            else $sql .= "'".$this->res($value)."'";
            $sql .= ', ';
        }

        $sql = rtrim($sql, ', ');
        $sql .= "WHERE ";

        if (is_array($id)) {
            $sql .= '(';
            foreach ($id as $id_column => $id_value) {
                $sql .= $id_column . " = '".$this->res($id_value)."' AND";
            }
            $sql = rtrim($sql, ' AND');
            $sql .= ')';
        }
        else {
            $id_column = '';
            $table_words = explode('_', $table);
            foreach ($table_words as $word) {
                $id_column .= $word[0];
            }
            $id_column .= '_id';
            $sql .= $id_column . " = '".$this->res($id)."'";
        }

        if ($debug) {
            echo $sql;
            return false;
        }
        else $this->query($sql);

        if ($this->affected_rows > 0) return true;
        else return false;
    }

    public function Row($sql) {
        $result = $this->query($sql);
        return $result->fetch_assoc();
    }

    public function gdb($sql) {
        $result = $this->query($sql);
        return $result->fetch_row()[0];
    }

    public function res($string) {
        return $this->real_escape_string($string);
    }
}