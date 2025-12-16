<?php 
namespace App\Models;
use App\Core\Model;
Class QueriesModel extends Model{
    public function getQueries($where,$limit,$offset){
        $sql= "SELECT * FROM queries WHERE $where ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->get_result();
    }
    public function getquerycount($where){
        $sql="SELECT COUNT(*) AS total from queries WHERE $where";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['total'];
    }
    public function getresolve($id){
        $sql="UPDATE queries SET status=1 WHERE id=?";
        $stmt=$this->conn->prepare($sql);
        $stmt->bind_param('i',$id);
        return $stmt->execute();
    }
}
