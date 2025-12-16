<?php
namespace App\Models;

use App\Core\Model;

class PayrollModel extends Model
{
    public function getTotalWorkingDays($year, $month)
    {
        return cal_days_in_month(CAL_GREGORIAN, $month, $year);
    }

    public function getSalaries()
    {
        $sql = "SELECT s.id AS salary_id, s.employee_id, s.basic_salary, s.hra_allowances AS hra, s.deduction AS fixed_deduction
                FROM salaries s
                WHERE s.status = 1";
        return $this->conn->query($sql);
    }

    public function getAttendance($employee_id, $year, $month)
    {
        $sql = "SELECT 
                    COUNT(CASE WHEN status=1 THEN 1 END) AS present_days,
                    COUNT(CASE WHEN status=0 THEN 1 END) AS absent_days
                FROM attendance
                WHERE employee_id = ? AND YEAR(date) = ? AND MONTH(date) = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iii", $employee_id, $year, $month);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function insertPayroll($employee_id, $salary_id, $month_date, $basic_salary, 
    $hra, $present_days, $absent_days, $gross_salary, $total_deductions, $net_salary,$absent_deduction)
    {
        $sql = "INSERT INTO payroll 
                (employee_id, salary_id, month, basic_salary, hra, present_days, absent_days, gross_salary, deductions, net_salary, status,absent_deduction)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iisdidddddd", $employee_id, $salary_id, $month_date, $basic_salary, $hra,
         $present_days, $absent_days, $gross_salary, $total_deductions, $net_salary,$absent_deduction);
       $stmt->execute();
    }

    public function payrollExists($employee_id, $month_date)
    {
        $sql = "SELECT payroll_id FROM payroll WHERE employee_id=? AND month=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("is", $employee_id, $month_date);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function insertPayslip($payroll_id, $employee_id, $month_date)
{
    $sql = "INSERT INTO payslips (payroll_id, employee_id, month) VALUES (?, ?, ?)";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("iis", $payroll_id, $employee_id, $month_date);
    $stmt->execute();
    return $stmt->insert_id;  
}

   public function payslipExists($payroll_id, $employee_id)
{
    $sql = "SELECT payslip_id FROM payslips WHERE payroll_id=? AND employee_id=?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("ii", $payroll_id, $employee_id);
    $stmt->execute();
    return $stmt->get_result()->num_rows > 0;
}


    public function getPayroll($month_start, $month_end, $limit, $offset)
    {
        $sql = "SELECT p.*, e.name, e.department
                FROM payroll p
                JOIN employees e ON p.employee_id = e.id
                WHERE p.month BETWEEN ? AND ?
                ORDER BY p.month DESC
                LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssii", $month_start, $month_end, $limit, $offset);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function markPaid($payroll_id)
    {
        $sql = "UPDATE payroll SET status=1 WHERE payroll_id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $payroll_id);
        $stmt->execute();
    }

    public function getPayrollCount($month_start, $month_end)
    {
        $sql = "SELECT COUNT(*) as total FROM payroll WHERE month BETWEEN ? AND ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $month_start, $month_end);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['total'];
    }
    public function getAttendanceCheck($year, $month)
{
    $sql = "SELECT id FROM attendance WHERE YEAR(date)=? AND MONTH(date)=? LIMIT 1";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("ii", $year, $month);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows;
}

public function updatePayroll(
    $payroll_id, $salary_id, $month_date, $basic_salary, 
    $hra, $present_days, $absent_days, $gross_salary, 
    $total_deductions, $net_salary, $absent_deduction)
{
    $sql = "UPDATE payroll SET 
                salary_id = ?, 
                month = ?, 
                basic_salary = ?, 
                hra = ?, 
                present_days = ?, 
                absent_days = ?, 
                gross_salary = ?, 
                deductions = ?, 
                net_salary = ?, 
                absent_deduction = ?
            WHERE payroll_id = ?";

    $stmt = $this->conn->prepare($sql);

    $stmt->bind_param("isisdiddddi", 
        $salary_id, 
        $month_date, 
        $basic_salary, 
        $hra, 
        $present_days, 
        $absent_days, 
        $gross_salary, 
        $total_deductions, 
        $net_salary, 
        $absent_deduction,
        $payroll_id
    );

    if ($stmt->execute()) {
        return true;
    } else {
        echo "Error updating payroll: " . $stmt->error;
        return false;
    }
}


}
