<?php
namespace App\Models;

use App\Core\Model;

class Attendance extends Model
{
    public function getTotalAttendanceCount($date, $where = "")
    {
        $sql = "SELECT COUNT(*) AS total FROM employees e
                LEFT JOIN attendance a 
                ON e.id = a.employee_id 
                AND a.date = ? 
                $where";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $date);
        $stmt->execute();
        
        $result = $stmt->get_result();
        return $result->fetch_assoc()['total'];
    }

    public function getEmployeesAttendance($date, $limit, $offset, $where = "")
    {
        $sql = "SELECT e.id, e.name, e.position, a.status, a.created_at
                FROM employees e
                LEFT JOIN attendance a 
                ON e.id = a.employee_id
                AND a.date = ?
                $where
                ORDER BY e.name
                LIMIT ? OFFSET ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sii", $date, $limit, $offset);
        $stmt->execute();
        
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function markAttendance($emp_id, $date, $status)
    {
        $sql = "SELECT id FROM attendance WHERE employee_id = ? AND date = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("is", $emp_id, $date); 
        $stmt->execute();
        $check = $stmt->get_result();

        if ($check->num_rows > 0) {
            return false;
        }
        $sql = "INSERT INTO attendance (employee_id, date, status) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iss", $emp_id, $date, $status); 
        
        if ($stmt->execute()) {
            return true;
        } else {
            error_log("Error inserting attendance: " . $stmt->error);
            return false;
        }
    }
}
