<?php
namespace App\Models;

use App\Core\Model;

class LoginModel extends Model
{
    public function getByEmail(string $email): array|false
    {
        $stmt = $this->conn->prepare("SELECT * FROM employees WHERE email = ? LIMIT 1");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            return $result->fetch_assoc(); 
        }

        return false; 
    }
}
