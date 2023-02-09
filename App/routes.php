<?php
use App\Controller\UserController;
use App\Controller\WebController;
use App\Model\User;

$userController = new UserController();
$webController = new WebController();

if ($_SERVER['HTTP_ACCEPT'] === 'application/json') {
    switch ($_SERVER['REQUEST_URI']) {
        case '/register':
            $userController->create();
            return;
        case '/login':
            $userController->login();
            return;
        case '/logout':
            $userController->logout();
            return;
    }
}

if (isset($_SESSION['user_id']) && $user = User::getById($_SESSION['user_id'])) {
    $webController->default(["name" => $user->name]);
} else {
    $webController->auth();
}
