<?php

namespace App\Services;

use App\Core\Database as DB;

class UserService {

    private $db;

    public function __construct() {
        $this->db = DB::getInstance()->getConnection();
    }

    public function getAllUsers() {
        $query = "SELECT * FROM users";
        $result = $this->db->query($query);

        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }

        return $users;
    }

    public function createUser($table, $data) {
        $result = DB::insert($table,$data);
        return $result;
    }

    public function updateUser($table, $data, $whereColumns) {
        $result= DB::update($table,$data, $whereColumns);
        return $result;
    }

    public function deleteUser($table, $whereColumns) {
        $result= DB::delete($table,$data);
        return $result;
    }
}
?>
