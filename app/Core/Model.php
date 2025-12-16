<?php
namespace App\Core;

class Model {
    protected $conn;
     public function __construct(){
        $this->conn = Database::getConnection();
    }
    public function getById(string $table, int $id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM $table WHERE id=? LIMIT 1");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    public function deleteById(string $table, int $id)
    {
        $stmt = $this->conn->prepare("DELETE FROM $table WHERE id=?");
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
    public function getAll(string $table, int $limit = 0, int $offset = 0)
    {
        $sql = "SELECT * FROM $table";
        if ($limit > 0) $sql .= " LIMIT $limit OFFSET $offset";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    // raw query execution
    public function rawQuery(string $sql, string $types = "", array $params = []): array {
        $stmt = $this->conn->prepare($sql);
        if ($types && $params) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return $result;
    }
}
