<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Services\UserService;
use App\Core\Request;

class UserController extends Controller {

    public function getIndex(Request $request) {
        $userService = new UserService();
        $users = $userService->getAllUsers();
        return $this->json($users);
    }

    public function postStore(Request $request) {
        $data = $request->getData();
        $userService = new UserService();
        $result = $userService->createUser('users', $data);
        if(!$result) return ['status' => "error"];
        return;
    }

    public function postUpdate(Request $request) {
        $data = $request->getData();
        $userService = new UserService();
        $result = $userService->updateUser('users', $data,['id' => 2]);
        echo json_encode($result);
    }

    public function deleteDestroy(Request $request) {
        $data = $request->getData();
        $userService = new UserService();
        $result = $userService->deleteUser($data['id']);
        echo json_encode($result);
    }
}
?>
