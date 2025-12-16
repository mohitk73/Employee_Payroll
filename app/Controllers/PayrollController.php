<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\PayrollModel;
use App\Helpers\Auth;

class PayrollController extends Controller
{
    public function index()
    {
        Auth::requireRole([1]); 

        $filter_month = $_POST['month'] ?? $_GET['month'] ?? date('Y-m');
        list($year, $month_num) = explode('-', $filter_month);

        $payrollModel = new PayrollModel();
        $total_working_days = $payrollModel->getTotalWorkingDays($year, $month_num);

    
        if (isset($_GET['pay']) && $_GET['pay'] == 1 && isset($_GET['payroll_id'])) {
            $payrollModel->markPaid((int)$_GET['payroll_id']);
            header("Location:/payroll?month=" . $filter_month);
            exit();
        }

        $block_generate = true;
        $today = date('Y-m');
        $last_completed_month = date("Y-m", strtotime("first day of last month"));
        $msg = "";

        if ($filter_month > $today) {
            $msg = "Payroll cannot be generated for an upcoming month!";
        } elseif ($filter_month == $today) {
            $msg = "Payroll cannot be generated for an ongoing month!";
        } else {
            $attendance_exists = $payrollModel->getAttendanceCheck($year, $month_num);
            if ($attendance_exists == 0) {
                $msg = "Payroll cannot be generated: No attendance data for $filter_month.";
            } else {
                $block_generate = false;
                $msg = "Payroll can be generated for $filter_month";
            }
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$block_generate) {
            $salaries = $payrollModel->getSalaries();
            foreach ($salaries as $row) {
                $employee_id = $row['employee_id'];
                $attendance = $payrollModel->getAttendance($employee_id, $year, $month_num);
                if (($attendance['present_days'] ?? 0) == 0) {
                    continue;
                }
                $present_days = $attendance['present_days'] ?? 0;
                $absent_days = $attendance['absent_days'] ?? ($total_working_days - $present_days);
                $per_day_salary = $row['basic_salary'] / $total_working_days;
                $gross_salary = $row['basic_salary'] + $row['hra'];
                $absent_deduction = $per_day_salary * $absent_days;
                
                $total_deductions = $row['fixed_deduction'] + $absent_deduction;
                $net_salary = $gross_salary - $total_deductions;

                $existing = $payrollModel->payrollExists($employee_id, "$filter_month-01");
                if ($existing) {
            $payroll_id = $existing['payroll_id'];
            $payrollModel->updatePayroll(
                $payroll_id,
                $row['salary_id'],
                "$filter_month-01",
                $row['basic_salary'],
                $row['hra'],
                $present_days,
                $absent_days,
                $gross_salary,
                $total_deductions,
                $net_salary,
                $absent_deduction
            );
        } else {
            $payroll_id = $payrollModel->insertPayroll(
                $employee_id,
                $row['salary_id'],
                "$filter_month-01",
                $row['basic_salary'],
                $row['hra'],
                $present_days,
                $absent_days,
                $gross_salary,
                $total_deductions,
                $net_salary,
                $absent_deduction
            );
        }
             $payslipexist = $payrollModel->payslipExists($payroll_id, $employee_id);

            if (!$payslipexist) {
                $payrollModel->insertPayslip($payroll_id, $employee_id, "$filter_month-01");
            } 
            }
            $msg = "Payroll generated for $filter_month!";
        }

        $limit = 5;
        $page = $_GET['page'] ?? 1;
        $page = max($page, 1);
        $offset = ($page - 1) * $limit;
        $month_start = "$filter_month-01";
        $month_end = date("Y-m-t", strtotime($month_start));
        $total_count = $payrollModel->getPayrollCount($month_start, $month_end);
        $totalpages = ceil($total_count / $limit);

        $payroll_result = $payrollModel->getPayroll($month_start, $month_end, $limit, $offset);

        $this->view('admin/payroll', [
            'payroll_result' => $payroll_result,
            'filtermonth' => $filter_month ?? null,
            'total_working_days' => $total_working_days,
            'page' => $page,
            'totalpages' => $totalpages,
            'msg' => $msg,
        ]);
    }
}
