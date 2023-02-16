<?php
namespace App\Controller;

use App\Helper\Validator;
use App\Model\User;
class UserController extends Controller
{
    public function create()
    {
        if ($_SERVER['HTTP_ACCEPT'] != 'application/json') {
            http_response_code(400);
            return;
        }
        $form = json_decode(file_get_contents('php://input'), true);
        $validator = Validator::validate($form)->min(2, 'name')->onlyLetters()
            ->hasDigits('password')->hasLetters()->min(6)->noSpaces()->noSpecials()
            ->areFieldsEqual('password', 'confirm_password')
            ->isEmail('email')->isUnique('users')
            ->min(6, 'login')->isUnique('users')->noSpaces();

        if ($validator->errors()) {
            echo json_encode(['errors' => $validator->errors()]);
        } else {
            $form['password'] = md5($form['login'] . $form['password']);
            $user = new User($form);
            $user->save();
        }
    }

    public function login()
    {
        $form = json_decode(file_get_contents('php://input'), true);
        $errors = [];
        if ($user = User::getByLogin($form['login'])) {
            file_put_contents($GLOBALS['basePath'] . 'id', json_encode($user));
            if ($user->password === md5($form['login'] . $form['password'])) {
                file_put_contents(__DIR__ . '/log', $user->id);
                $_SESSION['user_id'] = $user->id;
                echo json_encode(['status' => 'ok']);
                return;
            } else {
                $errors['password'][] = 'incorrect password';
            }
        } else {
            $errors['login'][] = 'could not find user';
        }

        echo json_encode(['errors' => $errors]);
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
    }
}