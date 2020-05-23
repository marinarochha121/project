<?php
class ProjectDB
{
    public $host        = 'localhost',
        $db_name     = 'project',
        $user        = 'root',
        $password    = '',
        $charset     = 'utf8',
        $pdo         = null,
        $last_id     = null;

    public function __construct()
    {
        $this->connect();
    }

    final protected function connect()
    {
        $pdo_details  = "mysql:host={$this->host};";
        $pdo_details .= "dbname={$this->db_name};";
        $pdo_details .= "charset={$this->charset};";

        try {
            $this->pdo = new PDO($pdo_details, $this->user, $this->password);
        } catch (PDOException $e) {
            die();
        }
    }

    public function query($stmt, $data = null)
    {
        $query      = $this->pdo->prepare($stmt);
        $check_exec = $query->execute($data);

        if ($check_exec) {
            return $query;
        } else {
            $error       = $query->errorInfo();
            $this->error = $error[2];
            return false;
        }
    }

    public function insert($table)
    {
        $cols = array();
        $placeHolders = '(';
        $values = array();
        $j = 1;
        $data = func_get_args();

        if (!isset($data[1]) || !is_array($data[1])) {
            return;
        }

        for ($i = 1; $i < count($data); $i++) {
            foreach ($data[$i] as $col => $val) {
                if ($i === 1) {
                    $cols[] = "`$col`";
                }

                if ($j <> $i) {
                    $placeHolders .= '), (';
                }

                $placeHolders .= '?, ';
                $values[] = $val;
                $j = $i;
            }

            $placeHolders = substr($placeHolders, 0, strlen($placeHolders) - 2);
        }

        $cols = implode(', ', $cols);

        $stmt = "INSERT INTO `$table` ( $cols ) VALUES $placeHolders) ";

        $insert = $this->query($stmt, $values);

        if ($insert) {
            if (
                method_exists($this->pdo, 'lastInsertId')
                && $this->pdo->lastInsertId()
            ) {
                $this->last_id = $this->pdo->lastInsertId();
            }

            return $this->last_id;
        }
        return;
    }

    public function update($table, $where_field, $where_field_value, $values)
    {
        if (empty($table) || empty($where_field) || empty($where_field_value)) {
            return;
        }

        $stmt = " UPDATE `$table` SET ";
        $set = array();
        $where = " WHERE `$where_field` = ? ";

        if (!is_array($values)) {
            return;
        }
        foreach ($values as $column => $value) {
            $set[] = " `$column` = ?";
        }

        $set = implode(', ', $set);
        $stmt .= $set . $where;
        $values[] = $where_field_value;
        $values = array_values($values);

        $update = $this->query($stmt, $values);
        if ($update) {
            return $update;
        }
        return;
    }

    public function delete($table, $where_field, $where_field_value)
    {
        if (empty($table) || empty($where_field) || empty($where_field_value)) {
            return;
        }

        $stmt = " DELETE FROM `$table` ";
        $where = " WHERE `$where_field` = ? ";
        $stmt .= $where;

        $values = array($where_field_value);
        $delete = $this->query($stmt, $values);

        if ($delete) {
            return $delete;
        }

        return;
    }
}
