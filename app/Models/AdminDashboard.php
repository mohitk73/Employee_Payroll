<?php

namespace App\Models;

use App\Core\Model;

class AdminDashboard extends Model
{
    public function getPayrollData($month_start, $month_end)
    {
        $sql = "SELECT SUM(net_salary) AS totalsalary, COUNT(*) AS totalemployee 
                FROM payroll WHERE month BETWEEN '$month_start' AND '$month_end'";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_assoc($result);
    }

    public function getDeductionData($month_start, $month_end)
    {
        $sql = "SELECT SUM(deductions) AS totaldeduction ,SUM(absent_deduction) AS absentdeduction
                FROM payroll WHERE month BETWEEN '$month_start' AND '$month_end'";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_assoc($result);
    }

    public function getActiveEmployees()
    {
        $sql = "SELECT COUNT(*) AS totalactive FROM employees WHERE status=1";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_assoc($result);
    }

    public function getAttendanceToday($today)
    {
        $sql_present = "SELECT COUNT(*) AS totalpresent FROM attendance WHERE date=CURDATE() AND status=1";
        $sql_absent = "SELECT COUNT(*) AS totalabsent FROM attendance WHERE date=CURDATE() AND status=0";

        $result_present = mysqli_query($this->conn, $sql_present);
        $result_absent = mysqli_query($this->conn, $sql_absent);

        return [
            'totalpresent' => mysqli_fetch_assoc($result_present)['totalpresent'],
            'totalabsent' => mysqli_fetch_assoc($result_absent)['totalabsent']
        ];
    }

    public function getLeaveData($month_start, $month_end)
    {
        $sql = "SELECT SUM(absent_days) AS totalleave 
                FROM payroll WHERE month BETWEEN '$month_start' AND '$month_end'";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_assoc($result);
    }

    public function getSalaryData()
    {
        $sql = "SELECT * FROM salaries LIMIT 1";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_assoc($result);
    }

     public function getHolidays($api_key, $country, $year)
    {
        $url = "https://calendarific.com/api/v2/holidays?api_key={$api_key}&country={$country}&year={$year}";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $holidays = [];

        if ($httpcode == 200 && $response) {
            $data = json_decode($response, true);
            if (isset($data['response']['holidays'])) {
                $holidays = $data['response']['holidays'];
            }
        }
        return $holidays;
    } 
   

    public function getAttendanceMarked($today)
    {
        $sql = "SELECT COUNT(*) as total FROM attendance WHERE Date(created_at) = '$today'";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_assoc($result);
    }


    //get all employees function
    public function getEmployees(array $filters = [], int $limit = 0, int $offset = 0)
    {
        $sql = "SELECT * FROM employees";
        $conditions = [];

        if (!empty($filters['name'])) {
            $name = $this->conn->real_escape_string($filters['name']);
            $conditions[] = "name LIKE '%$name%'";
        }
        if (!empty($filters['department'])) {
            $dept = $this->conn->real_escape_string($filters['department']);
            $conditions[] = "department='$dept'";
        }
        if (isset($filters['status']) && ($filters['status'] === "0" || $filters['status'] === "1")) {
            $status = $this->conn->real_escape_string($filters['status']);
            $conditions[] = "status='$status'";
        }

        if (count($conditions) > 0) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        if ($limit > 0) {
            $sql .= " LIMIT $limit OFFSET $offset";
        }

        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    //count employees function
    public function countEmployees(array $filters = [])
    {
        $sql = "SELECT COUNT(*) as total FROM employees";
        $conditions = [];

        if (!empty($filters['name'])) {
            $name = $this->conn->real_escape_string($filters['name']);
            $conditions[] = "name LIKE '%$name%'";
        }
        if (!empty($filters['department'])) {
            $dept = $this->conn->real_escape_string($filters['department']);
            $conditions[] = "department='$dept'";
        }
        if (isset($filters['status']) && ($filters['status'] === "0" || $filters['status'] === "1")) {
            $status = $this->conn->real_escape_string($filters['status']);
            $conditions[] = "status='$status'";
        }

        if (count($conditions) > 0) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $row = $this->conn->query($sql)->fetch_assoc();
        return $row['total'] ?? 0;
    }
    public function deleteEmployee(int $id)
    {
        return $this->deleteById('employees', $id);
    }
    //update employee function
   public function updateEmployee(int $id, array $data)
{
    $manager_id = isset($data['manager_id']) && !empty($data['manager_id']) ? $data['manager_id'] : null;
    $stmt = $this->conn->prepare("UPDATE employees SET 
        name=?, email=?, phone=?, role=?, position=?, department=?, manager_id=?, status=? WHERE id=?");

    $stmt->bind_param(
        "ssssssisi", 
        $data['name'],   
        $data['email'],  
        $data['phone'],  
        $data['role'],   
        $data['position'], 
        $data['department'], 
        $manager_id,   
        $data['status'],
        $id  
    );
    $result = $stmt->execute();
    if ($result) {
 
        header("Location:/admin_employees");
        exit(); 
    } else {
        $error[]="update failed";
    }
    return $result;
}

public function addEmployee(array $data)
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO employees 
                (name, email, password, role, phone, position, department, manager_id, date_of_joining, address, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
          $manager_id = isset($data['manager_id']) && !empty($data['manager_id']) ? $data['manager_id'] : null;
        $stmt->bind_param(
            "ssssssssssi",
            $data['name'],
            $data['email'],
            $data['password'],
            $data['role'],
            $data['phone'],
            $data['position'],
            $data['department'],
            $manager_id,
            $data['date_of_joining'],
            $data['address'],
            $data['status']
        );
        return $stmt->execute();
    }

    public function addSalary($employee_id, $basic_salary, $hra, $deductions){

        $stmt = $this->conn->prepare("INSERT INTO salaries (employee_id, basic_salary, hra_allowances, deduction) 
                                      VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iddd", $employee_id, $basic_salary, $hra, $deductions);
        return $stmt->execute();
    }

    public function checkSalaryExists($employee_id)
    {
        $sql = "SELECT * FROM salaries WHERE employee_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $employee_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    public function getAllEmployees()
    {
        $sql = "SELECT id, name FROM employees";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getmanagers(){
        $sql="SELECT name,id  FROM employees WHERE role=3";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);

    }

}
