<?php

namespace App\Core;

use mysqli;

class Database {
    private static $instance = null;
    private $connection;

    private function __construct() {
        $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($this->connection->connect_error) {
            die('Database connection failed: ' . $this->connection->connect_error);
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }

    public static function insert($table, $data) {
        $db = self::getInstance()->getConnection();

        $keys = implode(', ', array_keys($data));
        $values = implode("', '", array_values($data));

        $query = "INSERT INTO $table ($keys) VALUES ('$values')";

        $result = $db->query($query);
        if ($result) {
            return true;
        } else {
            return ['error' => 'Failed to insert data: ' . $db->error];
        }
    }

    public static function update($table, $data, $whereColumns) {
        $db = self::getInstance()->getConnection();

        $set = [];
        foreach ($data as $key => $value) {
            $set[] = "$key = '$value'";
        }
        $setClause = implode(', ', $set);

        $where = [];
        foreach ($whereColumns as $key => $value) {
            $where[] = "$key = '$value'";
        }
        $whereClause = implode(' AND ', $where);

        $query = "UPDATE $table SET $setClause WHERE $whereClause";

        $result = $db->query($query);
        if ($result) {
            return true;
        } else {
            return ['error' => 'Failed to update data: ' . $db->error];
        }
    }

    public static function delete($table, $whereColumns) {
        $db = self::getInstance()->getConnection();

        $where = [];
        foreach ($whereColumns as $key => $value) {
            $where[] = "$key = '$value'";
        }
        $whereClause = implode(' AND ', $where);

        $query = "DELETE FROM $table WHERE $whereClause";

        $result = $db->query($query);
        if ($result) {
            return true;
        } else {
            return ['error' => 'Failed to delete data: ' . $db->error];
        }
    }
}
?>
