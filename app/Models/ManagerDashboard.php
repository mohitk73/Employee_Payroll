<?php
namespace App\Models;
use App\Core\Model;
class ManagerDashboard extends Model{
   public function gettotal($manager_id){
    $sql="SELECT COUNT(*) AS total from employees e
            WHERE manager_id=?";
             $stmt=$this->conn->prepare($sql);
            $stmt->bind_param('i',$manager_id);
            $stmt->execute();
                $result = $stmt->get_result();
          $row = $result->fetch_assoc();
    return $row['total'] ?? 0; 

   }

        public function getpresent($manager_id){
            $sql="SELECT COUNT(*) AS present from attendance a 
            JOIN employees e ON a.employee_id=e.id
            WHERE a.date=CURDATE() AND a.status=1 AND e.manager_id= ?";

            $stmt=$this->conn->prepare($sql);
            $stmt->bind_param('i',$manager_id);
            $stmt->execute();
            $result = $stmt->get_result();
         $row = $result->fetch_assoc();
    return $row['present'] ?? 0; 

        }
         public function getabsent($manager_id){
            $sql="SELECT COUNT(*) AS present from attendance a 
            JOIN employees e ON a.employee_id=e.id
            WHERE a.date=CURDATE() AND a.status=0 AND e.manager_id= ?";

            $stmt=$this->conn->prepare($sql);
            $stmt->bind_param('i',$manager_id);
            $stmt->execute();
              $result = $stmt->get_result();
          $row = $result->fetch_assoc();
    return $row['absent'] ?? 0; 

        }
       public function getemployees($manager_id, $filters, $limit, $offset)
{
    $sql = "SELECT * FROM employees WHERE manager_id = ?";
    $types = "i";
    $params = [$manager_id];

    if (!empty($filters['name'])) {
        $sql .= " AND name LIKE ?";
        $types .= "s";
        $params[] = "%" . $filters['name'] . "%";
    }

    if (!empty($filters['department'])) {
        $sql .= " AND department = ?";
        $types .= "s";
        $params[] = $filters['department'];
    }

    if ($filters['status'] !== '') {
        $sql .= " AND status = ?";
        $types .= "i";
        $params[] = (int)$filters['status'];
    }

    $sql .= " ORDER BY name LIMIT ? OFFSET ?";
    $types .= "ii";
    $params[] = $limit;
    $params[] = $offset;

    return $this->rawQuery($sql, $types, $params);
}


       public function getemployeecount($manager_id, $filters): int
{
    $sql = "SELECT COUNT(*) AS total FROM employees WHERE manager_id = ?";
    $types = "i";
    $params = [$manager_id];

    if (!empty($filters['name'])) {
        $sql .= " AND name LIKE ?";
        $types .= "s";
        $params[] = "%" . $filters['name'] . "%";
    }

    if (!empty($filters['department'])) {
        $sql .= " AND department = ?";
        $types .= "s";
        $params[] = $filters['department'];
    }

    if ($filters['status'] !== '') {
        $sql .= " AND status = ?";
        $types .= "i";
        $params[] = (int)$filters['status'];
    }

    $result = $this->rawQuery($sql, $types, $params);
    return $result[0]['total'] ?? 0;
}

}