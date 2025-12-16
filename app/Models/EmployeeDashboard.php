<?php
namespace App\Models;
use App\Core\Model;
class EmployeeDashboard extends Model{
    public function latestpayroll(int $user_id): ?array{
        $sql="SELECT p.gross_salary, p.deductions,p.net_salary,p.month,p.present_days,p.absent_days,
SUM(CASE WHEN a.status = 1 THEN 1 END) AS presentdays,
SUM(CASE WHEN a.status = 0 THEN 1 END) AS absentdays
FROM payroll p
JOIN attendance a ON p.employee_id = a.employee_id
WHERE p.employee_id = ?
  AND p.month = (SELECT MAX(month) FROM payroll WHERE employee_id=?)
GROUP BY p.month, p.gross_salary, p.deductions, p.net_salary,p.present_days,p.absent_days
LIMIT 3
";
$result=$this->rawQuery($sql,'ii',[$user_id,$user_id]);
return $result[0] ?? null;
    }

    public function attendancestatus($user_id){
        $sql="SELECT a.* FROM attendance a WHERE employee_id=? AND date=CURDATE()";
        $result=$this->rawQuery($sql,'i',[$user_id]);
return $result[0] ?? null;
    }

    public function getqueries($user_id){
        $sql="SELECT * FROM queries WHERE employee_id=? ORDER BY created_at DESC";
         $result=$this->rawQuery($sql,'i',[$user_id]);
return $result;
    }
}