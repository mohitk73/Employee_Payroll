<?php
namespace App\Models;
use App\Core\Model;

class ContactModel extends Model{
    public function sendquery($userid,array $data){
        $sql="INSERT INTO queries (employee_id, name, email, subject, message)
                VALUES (?,?,?,?,?)";

                $stmt=$this->conn->prepare($sql);
                $stmt->bind_param('issss',
                $userid,
                $data['name'],
                $data['email'],
                $data['subject'],
                $data['message']
    );
   return $stmt->execute();
    }

}