<?php
namespace App\Helpers;

class Auth
{
    private static function initSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    public static function checkLogin(): void
    {
        
 self::initSession();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }
    }

    public static function requireRole(array $roles): void
    {
        self::checkLogin();

        if (!in_array($_SESSION['role'], $roles)) {
            header("HTTP/1.0 403 Forbidden");
            include __DIR__ . '/../views/layout/access.php';
            exit();
        }
    }
    public static function redirectIfLoggedIn(): void
    {
         self::initSession();
        if (isset($_SESSION['role'])) {
            $role = $_SESSION['role'];
            if ($role == 'admin' || $role == 1) {
                header("Location: /admin_dashboard");
            } 
            elseif ($role == 'HR' || $role == 2) {
                header("Location: /manager/dashboard");
            }elseif ($role == 'Manager' || $role == 3) {
                header("Location: /manager/dashboard");
            }
            else{
                   header("Location: /employee/dashboard");
            }
            exit();
        }
    }
    public static function logout(): void
    {
       self::initSession();
        session_destroy();
        header("Location: /login");
        exit();
    }
}
