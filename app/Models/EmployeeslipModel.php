<?php
namespace App\Models;
use App\Core\Model;
class EmployeeslipModel extends Model{
        public function getpayslip($emp_id, $fullmonth)
{
    $sql = "SELECT p.*, s.*, e.id, e.name, e.position, e.date_of_joining AS joining 
            FROM payroll p
            JOIN employees e ON p.employee_id = e.id
            JOIN salaries s ON p.salary_id = s.id
            WHERE p.employee_id = ? AND DATE_FORMAT(p.month, '%Y-%m-%d') = ?
            LIMIT 1";

    if ($stmt = $this->conn->prepare($sql)) {
        $stmt->bind_param('is', $emp_id, $fullmonth);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
           return $result;    
}
    }
}
