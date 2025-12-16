<?php
namespace App\Controllers;

use App\Helpers\Auth;

class LogoutController
{
    public function index()
    {
        Auth::logout();
    }
}
