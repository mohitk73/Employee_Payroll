<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\Auth;
use App\Models\PayrollModel;
use App\Models\PayslipModel;
use Mpdf\Mpdf; // Import the mPDF class at the top


class PayslipController extends Controller
{
    public function index()
    {
        
        Auth::requireRole([1,2]); 
        $emp_id = intval($_GET['emp']);
        $month = $_GET['month'];
        $filter_month = $_POST['month'] ?? $_GET['month'] ?? date('Y-m');
        list($year, $month_num) = explode('-', $filter_month);
        $payrollModel = new PayrollModel;
        $total_working_days = $payrollModel->getTotalWorkingDays($year, $month_num);

        $payslip = new PayslipModel;
        $result = $payslip->getpayslip($emp_id, $month);
        $perday_salary = $result['basic_salary'] / $result['total_working_days'];
        $totalworking = $result['present_days'] + $result['absent_days'];
        $absentdeduction = $perday_salary * $result['absent_days'];
        $pay_month = $result['month'];
        $pay_date = date("Y-m-06", strtotime($pay_month . " +1 month"));
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header("Location: /payroll?month=" . $month);
            exit();
        }

        $this->view('/admin/payslip', [
            'totalworking' => $totalworking,
            'absentdeduction' => $absentdeduction,
            'paydate' => $pay_date,
            'result' => $result,
        ]);
    }

    public function payslips()
    {
        Auth::requireRole([1,2]); 
        $month = isset($_GET['month']) ? $_GET['month'] : '';
             $limit = 3;
        $page = $_GET['page'] ?? 1;
        $page = max($page, 1);
        $offset = ($page - 1) * $limit;

        $payslipModel=new PayslipModel();
        $totalcount=$payslipModel->getpayslipcount($month);
        $totalpages = ceil($totalcount / $limit);
        $payslips=$payslipModel->getallpayslips($month,$limit,$offset);

         $this->view('admin/payslips', [
            'payslips' => $payslips,
            'month' => $month,
            'totalpages' => $totalpages,
            'page' => $page
        ]);
    }

     public function downloadPayslip()
{
    $emp_id = $_GET['emp'];
    $month = $_GET['month'];

    // Check if the logged-in user is authorized to download the payslip
    if ($_SESSION['role'] == 3 && $_SESSION['user_id'] != $emp_id) {
        // Employees can only download their own payslips
        $_SESSION['msg'] = "Unauthorized access!";
        header("Location: /payroll");
        exit();
    }

    // Fetch the payslip data for the requested employee and month
    $payslipModel = $this->model('PayslipModel');
    $result = $payslipModel->getPayslip($emp_id, $month);
if (!$result) {
        $_SESSION['msg'] = "Payslip not found!";
        header("Location: /payroll");
        exit();
    }
    $perday_salary = $result['basic_salary'] / $result['total_working_days'];
    $absentdeduction = $perday_salary * $result['absent_days'];
    $pay_date = date("Y-m-06", strtotime($result['month'] . " +1 month"));
    $this->generatePayslipPDF($result, $pay_date, $absentdeduction);
}
   private function generatePayslipPDF($result, $paydate, $absentdeduction)
{
    $html = $this->render('admin/pdfpayslip', [
        'result' => $result,
        'paydate' => $paydate,
        'absentdeduction' => $absentdeduction,
    ]);

    $mpdf = new Mpdf();
    $mpdf->WriteHTML($html);
    $mpdf->Output('payslip_' . $result['payslip_id'] . '.pdf', 'D');
}
}