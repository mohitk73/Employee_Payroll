<?php
namespace App\Models;
use App\Core\Model;
class ProfileModel extends Model{
    public function getprofile($userid){
        $sql="SELECT * FROM employees WHERE id=?";
        $stmt=$this->conn->prepare($sql);
        $stmt->bind_param('i',$userid);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}