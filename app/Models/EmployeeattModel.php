<?php
namespace App\Models;
use App\Core\Model;
class EmployeeattModel extends Model{
    public function gettotalattendance($user_id){
         $sql = "SELECT 
                    COUNT(CASE WHEN status=1 THEN 1 END) AS presentdays,
                    COUNT(CASE WHEN status=0 THEN 1 END) AS absentdays
                FROM attendance
                WHERE employee_id=?";
        $result = $this->rawQuery($sql, 'i', [$user_id]);
        return $result[0] ?? ['presentdays'=>0, 'absentdays'=>0];
    }

    public function attendanceHistory(int $user_id, int $limit, int $offset, ?string $from = null, ?string $to = null, ?int $status = null): array
    {
        $where = "employee_id=?";
        $params = [$user_id];
        $types = 'i';

        if ($from) {
            $where .= " AND date>=?";
            $types .= 's';
            $params[] = $from;
        }
        if ($to) {
            $where .= " AND date<=?";
            $types .= 's';
            $params[] = $to;
        }
       if ($status === 0 || $status === 1) {
    $where .= " AND status = ?";
    $types .= 'i';
    $params[] = (int)$status;
}

        $sql = "SELECT * FROM attendance WHERE $where ORDER BY date DESC LIMIT ? OFFSET ?";
        $types .= 'ii';
        $params[] = $limit;
        $params[] = $offset;

        return $this->rawQuery($sql, $types, $params);
    }

    public function attendanceCount(int $user_id, ?string $from = null, ?string $to = null, ?int $status = null): int
    {
        $where = "employee_id=?";
        $params = [$user_id];
        $types = 'i';

        if ($from) {
            $where .= " AND date>=?";
            $types .= 's';
            $params[] = $from;
        }
        if ($to) {
            $where .= " AND date<=?";
            $types .= 's';
            $params[] = $to;
        }
     if ($status === 0 || $status === 1) {
    $where .= " AND status = ?";
    $types .= 'i';
    $params[] = (int)$status;
}
        $sql = "SELECT COUNT(*) AS total FROM attendance WHERE $where";
        $result = $this->rawQuery($sql, $types, $params);
        return $result[0]['total'] ?? 0;
    }
}