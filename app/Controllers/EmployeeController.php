<?php

namespace App\Controllers;

use App\Helpers\Auth;
use App\Helpers\Session;
use App\Core\Controller;
use App\Models\AdminDashboard;
use App\Models\EmployeeDashboard;

class EmployeeController extends Controller
{
  public function empdashboard()
  {
    Auth::requireRole([0]);
    $today = date("Y-m-d");
    $user_id = Session::get('user_id');
    $employeeModel = new EmployeeDashboard();
    $payrolldetails = $employeeModel->latestpayroll($user_id);
    $attendancestatus = $employeeModel->attendancestatus($user_id);
    $queries = $employeeModel->getqueries($user_id);
    $totalworking = $payrolldetails['present_days'] + $payrolldetails['absent_days'];
    $totalworkingdays = $payrolldetails['presentdays'] + $payrolldetails['absentdays'];
    $attendancepercentage = ($totalworkingdays > 0) ? round($payrolldetails['presentdays'] / $totalworkingdays * 100, 2) : 0;
    $paydate = date("Y-m-06", strtotime($payrolldetails['month'] . " +1 month"));
    $nextpaydate = date("Y-m-06", strtotime($payrolldetails['month'] . " +2 month"));
    $holidayModel = new AdminDashboard();
    $year = date('Y');
    $holidays = $holidayModel->getHolidays($_ENV['HOLIDAY_API_KEY'], "IN", $year);

    $this->view('employee/dashboard', [
      'today' => $today,
      'payrolldetails' => $payrolldetails,
      'attendancestatus' => $attendancestatus,
      'queries' => $queries,
      'attendancepercentage' => $attendancepercentage,
      'totalworkingdays' => $totalworkingdays,
      'paydate' => $paydate,
      'nextpaydate' => $nextpaydate,
      'holidays' => $holidays,
    ]);
  }
}
