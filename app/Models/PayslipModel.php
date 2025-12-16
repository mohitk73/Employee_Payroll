<?php

namespace App\Models;

use App\Core\Model;

class PayslipModel extends Model
{
    public function getpayslip($emp_id, $month)
    {
        $sql = "SELECT p.*,s.*,ps.payslip_id ,e.id,e.name,e.position,e.date_of_joining AS joining FROM payroll p 
JOIN employees e ON p.employee_id=e.id 
JOIN salaries s ON p.salary_id = s.id
LEFT JOIN payslips ps ON ps.payroll_id = p.payroll_id
where p.employee_id=? AND p.month=?
LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('is', $emp_id, $month);
        $stmt->execute();
         $result = $stmt->get_result()->fetch_assoc();
        return $result;
    }

    public function getallpayslips($month,$limit,$offset){
        $sql = "SELECT p.*, e.id, e.name, ps.payslip_id
        FROM payroll p
        JOIN employees e ON p.employee_id = e.id
        JOIN payslips ps ON p.payroll_id = ps.payroll_id
        WHERE DATE_FORMAT(p.month, '%Y-%m') = ? 
        LIMIT ? OFFSET ?";
        $stmt=$this->conn->prepare($sql);
        $stmt->bind_param('sii',$month,$limit,$offset);
        $stmt->execute();
         $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);

    }
    public function getpayslipcount($month){
          $sql = "SELECT COUNT(*) AS total 
                FROM payroll p
                JOIN payslips ps ON p.payroll_id = ps.payroll_id
                WHERE DATE_FORMAT(p.month, '%Y-%m') = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $month);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['total'];

    }
}
