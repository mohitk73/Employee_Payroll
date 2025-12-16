<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\ProfileModel;
use App\Helpers\Auth;
use App\Helpers\Session;
class ProfileController extends Controller{
    public function profile(){
        Auth::requireRole([1,0,2,3]); 
        $userid=Session::get('user_id');
        $profileModel=new ProfileModel();
        $profiledetails=$profileModel->getprofile($userid);
        $roles=[
            0 => "Employee",
            1 => "Admin",
            2 => "HR",
            3 => "Manager"
        ];
        $status=[
             0 => "Inactive",
            1 => "Active"
        ];
        $statusText = $status[$profiledetails['status']];
        $statusClass = ($profiledetails['status'] == 1) ? "active" : "inactive";

        if (Session::get('role') == 1) {
            $dashboard = "/admin_dashboard";
        } elseif (Session::get('role') == 2) {
            $dashboard = "/hr/dashboard";
        } elseif (Session::get('role') == 3) {
            $dashboard = "/manager/dashboard";
        } else {
            $dashboard = "/employee/dashboard";
        }


        $this->view('profile', [
            'profiledetails' => $profiledetails,
            'roles' => $roles,
            'statusText' => $statusText,
            'statusClass' => $statusClass,
            'dashboard' => $dashboard
        ]);
    }
}