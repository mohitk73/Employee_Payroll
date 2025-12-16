<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\Auth;
use App\Models\EmployeeslipModel;

class EmployeeslipController extends Controller
{
    public function index()
    {
        Auth::requireRole([0, 3]);

        $emp_id = $_SESSION['user_id'];
        $message = "";
        $month = $_GET['month'] ?? null;
        $fullmonth = $month ? $month . '-01' : null;

        if (!$month) {
            $message = "Please select a month.";
        } else {

            $payslipModel = new EmployeeslipModel();
            $result = $payslipModel->getpayslip($emp_id, $fullmonth);

            if (!$result) {

                $message = "No payslip found for the selected month.";
            } else {

                $perday_salary = $result['basic_salary'] / $result['total_working_days'];
                $totalworking = $result['present_days'] + $result['absent_days'];
                $absentdeduction = $perday_salary * $result['absent_days'];
                $pay_month = $result['month'];
                $pay_date = date("Y-m-06", strtotime($pay_month . " +1 month"));
            }
        }

        $this->view('employee/emppayslip', [
            'message' => $message,
            'result' => $result ?? null,
            'totalworking' => $totalworking ?? 0,
            'absentdeduction' => $absentdeduction ?? 0,
            'pay_date' => $pay_date ?? null
        ]);
    }
}
