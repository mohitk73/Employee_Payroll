<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Salarystructure;
use App\Helpers\Auth;

class SalaryController extends Controller
{
    public function index()
    {
        Auth::requireRole([1,2]); 

        $limit = 5;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;
        $offset = ($page - 1) * $limit;

        $where = "1=1";
        if (!empty($_GET['name'])) {
            $name = $_GET['name'];
            $where .= " AND e.name LIKE '%$name%'";
        }

        if (!empty($_GET['department'])) {
            $department =  $_GET['department'];
            $where .= " AND e.department = '$department'";
        }
        $salaryModel = $this->model('Salarystructure');

        $counttotal = $salaryModel->getsalarycount($where);
        $totalpages = ceil($counttotal / $limit);
        $salaries = $salaryModel->getsalaries($where, $limit, $offset);
        $this->view('admin/salarystructure', [
            'salaries' => $salaries,
            'totalpages' => $totalpages,
            'page' => $page,
            'name' => $_GET['name'] ?? '',
            'department' => $_GET['department'] ?? ''
        ]);
    }

    public function search()
{

    $name = $_GET['name'] ?? '';

    $where = "1=1";
    if (!empty($name)) {
        $name = addslashes($name);
        $where .= " AND e.name LIKE '%$name%'";
    }

    $salaryModel = $this->model('Salarystructure');
    $salaries = $salaryModel->getsalaries($where, 10, 0);

    header('Content-Type: application/json');
    echo json_encode($salaries);
    exit;
}


   public function update()
{
    Auth::requireRole([1]); 

    if (!isset($_GET['id']) || empty($_GET['id'])) {
        header("Location:/salarystructure");
        exit();
    }

    $id = intval($_GET['id']);
    $salaryModel = $this->model('Salarystructure');
    $salary = $salaryModel->getsalarybyid($id);

    if (!$salary) {
        header("Location:/salarystructure");
        exit();
    }

    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $basic_salary = $_POST['basic_salary'];
        $hra = $_POST['hra'];
        $deductions = $_POST['deductions'];

        if (!is_numeric($basic_salary) || $basic_salary <= 0) {
            $errors[] = "Basic Salary must be a valid positive number.";
        }
        if (!is_numeric($hra) || $hra < 0) {
            $errors[] = "HRA must be a valid positive number.";
        }

        if (!is_numeric($deductions) || $deductions < 0) {
            $errors[] = "Deductions must be a valid positive number.";
        }
         // Limits
        $maxBasicSalary = 100000000;
        $maxHra         = 9999999.99;
        $maxDeductions  = 5000000;

        if (is_numeric($basic_salary) && $basic_salary > $maxBasicSalary) {
            $errors[] = "Basic Salary cannot exceed ₹1,000,000,00";
        }

        if (is_numeric($hra) && $hra > $maxHra) {
            $errors[] = "HRA cannot exceed ₹999,999.99.";
        }

        if (is_numeric($deductions) && $deductions > $maxDeductions) {
            $errors[] = "Deductions cannot exceed ₹500,000.";
        }

        if (is_numeric($basic_salary) && !preg_match('/^\d+(\.\d{1,2})?$/', $basic_salary)) {
            $errors[] = "Basic Salary can have max 2 decimal places.";
        }

        if (is_numeric($hra) && !preg_match('/^\d+(\.\d{1,2})?$/', $hra)) {
            $errors[] = "HRA can have max 2 decimal places.";
        }

        if (is_numeric($deductions) && !preg_match('/^\d+(\.\d{1,2})?$/', $deductions)) {
            $errors[] = "Deductions can have max 2 decimal places.";
        }


            if (empty($errors)) {
                $updated = $salaryModel->updatesalary($id, $basic_salary, $hra, $deductions);

                if ($updated) {
                    header("Location:/salarystructure");
                    exit();
                } else {
                    $errors[] = "Something went wrong while updating. Try again.";
                }
            }
    }

    $this->view("admin/updatesalary", [
        'salary' => $salary,
        'errors' => $errors
    ]);
}


}


