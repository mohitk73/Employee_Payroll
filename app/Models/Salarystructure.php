<?php
namespace App\Models;
use App\Core\Model;

Class Salarystructure extends Model{
    public function getsalarycount($where){
    $sql = "SELECT COUNT(*) AS total 
            FROM salaries s
            JOIN employees e ON s.employee_id = e.id 
            WHERE $where";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc()['total'];
}

//getsalry
    public function getsalaries($where,$limit,$offset){
        $sql = "SELECT s.id AS salary_id, e.id AS emp_id, e.name, e.department, s.basic_salary, s.hra_allowances AS hra, s.deduction AS deductions
        FROM salaries s
        JOIN employees e ON s.employee_id = e.id WHERE $where ORDER BY s.id LIMIT ? OFFSET ?";
            $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $limit,$offset);
        $stmt->execute();
          $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

     public function getsalarybyid($id)
    {
        $sql = "SELECT * FROM salaries WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }


    //uodate salary
    public function updatesalary($id, $basic_salary, $hra, $deductions)
    {
        $sql = "UPDATE salaries 
                SET basic_salary = ?, hra_allowances = ?, deduction = ?
                WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("dddi", $basic_salary, $hra, $deductions, $id);
        return $stmt->execute();
    }
}