<?php 
namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\Auth;
use App\Models\QueriesModel;
class QueriesController extends Controller{
    public function queries(){
        Auth::requireRole([1]); 
         $limit = 10;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;
        $offset = ($page - 1) * $limit;
        $sn = ($page - 1) * $limit + 1;
        $where = "1";  

        if (!empty($_GET['date'])) {
            $date =  $_GET['date'];
            $where .= " AND DATE(created_at) = '$date'";
        }
        if (isset($_GET['status']) && $_GET['status'] != '') {
            $status = (int)$_GET['status'];
            $where .= " AND status = '$status'";
        }
        $queriesModel = new QueriesModel();
        $totalCount = $queriesModel->getQueryCount($where);
        $totalPages = ceil($totalCount / $limit);

        $queries = $queriesModel->getQueries($where, $limit, $offset);

        if (isset($_POST['resolve'])) {
            $id = $_POST['id'];
            $queriesModel->getresolve($id);
            header("Location: /queries");
            exit();
        }

        $this->view('admin/queries', [
            'queries' => $queries,
            'totalpages' => $totalPages,
            'page' => $page,
            'sn' => $sn,
            'status' => $_GET['status'] ?? '',
            'date' => $_GET['date'] ?? ''
        ]);
    }
}