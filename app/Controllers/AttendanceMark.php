<?php

namespace App\Controllers;

use App\Helpers\Auth;
use App\Core\Controller;
use App\Helpers\Session;
use mysqli;

class AttendanceMark extends Controller
{

    public function index()
    {
        Auth::requireRole([1,2,3]);
        $date = $_GET['date'] ?? date("Y-m-d");
        $name = $_GET['name'] ?? '';
        $status = $_GET['status'] ?? '';

        $role = Session::get('role');
        $where = [];

        if ($role == 3) {
            $manager_id = Session::get('user_id');
            $where[] = "e.manager_id = '$manager_id'";
        }
        if (!empty($_GET['name'])) {
            $name = $_GET['name'];
            $where[]=" e.name LIKE '%$name%'";
        }

        if ($status === "1" || $status === "0") {
            $where[] = "a.status = '$status'";
        } elseif ($status === "null") {
            $where[] = "a.status IS NULL";
        }

        $wherestm = !empty($where) ? "WHERE " . implode(" AND ", $where) : "";


        $attendance = $this->model('Attendance');
        $limit = 4;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;
        $offset = ($page - 1) * $limit;
        $sn = ($page - 1) * $limit + 1;
        $count = $attendance->getTotalAttendanceCount($date, $wherestm);
        $totalPages = ceil($count / $limit);

        $employees = $attendance->getEmployeesAttendance($date, $limit, $offset, $wherestm);

        $this->view('admin/attendance', [
            'employees' => $employees,
            'totalpages' => $totalPages,
            'page' => $page,
            'date' => $date,
            'name' => $name,
            'status' => $status
        ]);
    }

    //mark attendance
    public function mark()
    {
        Auth::requireRole([1,2,3]);
        $emp_id = $_GET['emp_id'];
        $status = $_GET['status'];
        $date = date("Y-m-d");
        if ($status !== '1' && $status !== '0') {
            $_SESSION['msg'] = "Invalid status!";
            header("Location:/admin_attendance");
            exit();
        }
        $attendance = $this->model('Attendance');
        if ($attendance->markAttendance($emp_id, $date, $status)) {
            $_SESSION['msg'] = "Attendance saved successfully!";
        } else {
            $_SESSION['msg'] = "Attendance already marked!";
        }
        header("Location:/admin_attendance");
        exit();
    }
}
