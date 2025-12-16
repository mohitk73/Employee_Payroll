<?php

namespace App\Controllers;

use App\Helpers\Auth;
use App\Core\Controller;
use App\Helpers\Session;
use App\Models\AdminDashboard;
use App\Models\ManagerDashboard;

class ManagerController extends Controller
{
    public function index()
    {
        Auth::requireRole([3]);
        $manager_id = Session::get('user_id');
        $managerModel = new ManagerDashboard();
        $today=date('Y-m-d');
        $present = $managerModel->getpresent($manager_id);
        $absent = $managerModel->getabsent($manager_id);
        $totalemp = $managerModel->gettotal($manager_id);
            $holidayModel = new AdminDashboard();
    $year = date('Y');
    $holidays = $holidayModel->getHolidays($_ENV['HOLIDAY_API_KEY'], "IN", $year);

        $this->view('manager/dashboard', [
            'present' => $present,
            'absent' => $absent,
            'totalemp' => $totalemp,
            'holidays'=>$holidays,
            'today'=>$today,
        ]);
    }

    public function employees()
    {
        Auth::requireRole([3]);
        $manager_id = Session::get('user_id');
        $managerModel = new ManagerDashboard();
        $limit = 5;
        $where = '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;

        $offset = ($page - 1) * $limit;
        $filters = [
            'name' => $_GET['name'] ?? '',
            'department' => $_GET['department'] ?? '',
            'status' => $_GET['status'] ?? ''
        ];
        $count = $managerModel->getemployeecount($manager_id, $filters);
        $totalpages = ceil($count / $limit);
        $results = $managerModel->getemployees($manager_id, $filters, $limit, $offset);
   

        $this->view('/manager/employees', [
            'results' => $results,
            'totalpages' => $totalpages,
            'page' => $page,
            'filters' => $filters,

        ]);
    }
}
