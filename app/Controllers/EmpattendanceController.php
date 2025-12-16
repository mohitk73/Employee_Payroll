<?php

namespace App\Controllers;

use App\Helpers\Session;
use App\Models\EmployeeattModel;
use App\Helpers\Auth;
use App\Core\Controller;
use App\Models\EmployeeDashboard;

class EmpattendanceController extends Controller
{
    public function attendance()
    {
        Auth::requireRole([0]);

        $user_id = Session::get('user_id');
        $today = date("Y-m-d");
        $limit = 10;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $from = $_GET['from'] ?? null;
        $to = $_GET['to'] ?? null;
        $status = $_GET['status'] ?? null;
        if ($status === '' || $status === null) {
            $status = null;
        } elseif ($status === '0') {
            $status = 0;
        } elseif ($status === '1') {
            $status = 1;
        }

        $attendanceModel = new EmployeeattModel();
        $attendancestatus = new EmployeeDashboard();
        $todayAttendance = $attendancestatus->attendancestatus($user_id);
        $summary = $attendanceModel->gettotalattendance($user_id);
        $history = $attendanceModel->attendanceHistory($user_id, $limit, $offset, $from, $to, $status);
        $totalCount = $attendanceModel->attendanceCount($user_id, $from, $to, $status);

        $totalPages = ceil($totalCount / $limit);
        $sn = $offset + 1;
        $present = $summary['presentdays'];
        $absent = $summary['absentdays'];
        $totalworking = $summary['presentdays'] + $summary['absentdays'];
        $percentage = ($totalworking > 0) ? round(($summary['presentdays'] / $totalworking) * 100, 2) : 0;

        $this->view('employee/empattendance', [
            'today' => $today,
            'todayattendance' => $todayAttendance,
            'summary' => $summary,
            'history' => $history,
            'sn' => $sn,
            'present' => $present,
            'absent' => $absent,
            'totalworking' => $totalworking,
            'percentage' => $percentage,
            'totalpages' => $totalPages,
            'page' => $page,
            'from' => $from,
            'to' => $to,
            'statusFilter' => $status
        ]);
    }
}
