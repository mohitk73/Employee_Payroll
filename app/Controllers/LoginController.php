<?php

namespace App\Controllers;

use App\Models\LoginModel;
use App\Helpers\Session;
use App\Helpers\Auth;

class LoginController
{
    public function index()
    {
        Auth::redirectIfLoggedIn();
        include "../app/views/login.php";
    }
    public function auth()
    {
        Session::start();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = htmlspecialchars(trim($_POST['email']));
            $password = $_POST['password'];

            $loginModel = new LoginModel();
            $user = $loginModel->getByEmail($email);
            if (!$user) {
                Session::set('error', 'Email Not Found!');
                header("Location:/login");
                exit();
            }
            if (!password_verify($password, $user["password"])) {
                Session::set('error', 'password incorrect');
                header("Location:/login");
                exit();
            }
            Session::set("user_id", $user["id"]);
            Session::set("name", $user["name"]);
            Session::set("role", $user["role"]);
            Session::set("manager_id", $user["manager_id"]);

            switch ($user['role']) {
                case 1:
                    header("Location:/admin_dashboard");
                    exit();
                case 2:
                    header("Location:/hr/dashboard");
                    exit();
                case 3:
                    header("Location:/manager/dashboard");
                    exit();
                case 0:
                    header("Location:/employee/dashboard");
                    exit();
                default:
                    die("Invalid Role!");
            }
        }
    }
}
