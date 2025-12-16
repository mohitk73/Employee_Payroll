<?php

namespace App\Controllers;

use App\Helpers\Auth;
use App\Core\Controller;

class DashboardController extends Controller
{
    //admin function
    public function admin()
    {
        Auth::requireRole([1,2]);
        $today = date("Y-m-d");
        $month_start = date('Y-m-01', strtotime("first day of last month"));
        $month_end = date("Y-m-t", strtotime($month_start));

        $dashboardModel = $this->model('AdminDashboard');

        $payrollData = $dashboardModel->getPayrollData($month_start, $month_end);
        $deductionData = $dashboardModel->getDeductionData($month_start, $month_end);
        $activeEmployeeData = $dashboardModel->getActiveEmployees();
        $attendanceData = $dashboardModel->getAttendanceToday($today);
        $leaveData = $dashboardModel->getLeaveData($month_start, $month_end);
        $salaryData = $dashboardModel->getSalaryData();
        $year = date('Y');
        $holidays = $dashboardModel->getHolidays($_ENV['HOLIDAY_API_KEY'], "IN", $year); 

        $attendanceMarked = $dashboardModel->getAttendanceMarked($today);
        $role = [
            1 => 'Admin',
            2=>'HR',
    ];
        $this->view('admin/dashboard', [
            'today' => $today,
            'month_start' => $month_start,
            'month_end' => $month_end,
            'payrollData' => $payrollData,
            'deductionData' => $deductionData,
            'activeEmployeeData' => $activeEmployeeData,
            'attendanceData' => $attendanceData,
            'leaveData' => $leaveData,
            'salaryData' => $salaryData,
            'holidays' => $holidays,
            'attendanceMarked' => $attendanceMarked,
            'role' => $role
        ]);
    }

    //employees list function
    public function employees()
    {
       Auth::requireRole([1,2]);

        $dashboardModel = $this->model('AdminDashboard');

        $filters = [
            'name' => $_GET['name'] ?? '',
            'department' => $_GET['department'] ?? '',
            'status' => $_GET['status'] ?? ''
        ];
        $limit = 5;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;
        $offset = ($page - 1) * $limit;

        if (isset($_GET['id'])) {
            $dashboardModel->deleteEmployee((int)$_GET['id']);
            header("Location:/admin_employees");
            exit();
        }

        $employees = $dashboardModel->getEmployees($filters, $limit, $offset);
        $totalEmployees = $dashboardModel->countEmployees($filters);
        $totalPages = ceil($totalEmployees / $limit);
        $roles = [0 => 'Employee', 1 => 'Admin', 2 => 'HR', 3 => 'Manager'];

        $this->view('admin/employees', [
            'employees' => $employees,
            'totalPages' => $totalPages,
            'page' => $page,
            'filters' => $filters,
            'roles' => $roles
        ]);
    }

    //add employee
   public function addEmployee()
{
      Auth::requireRole([1,2]);
    $error = [];
 $dashboardModel = $this->model('AdminDashboard'); 

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $data = [
            'name' => htmlspecialchars($_POST['name']),
            'email' => $_POST['email'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'role' => $_POST['role'],
            'phone' => $_POST['phone'],
            'position' => htmlspecialchars($_POST['position']),
            'department' => $_POST['department'],
            'manager_id' => $_POST['manager_id'] ?? null, 
            'date_of_joining' => $_POST['date_of_joining'],
            'address' => htmlspecialchars($_POST['address']),
            'status' => $_POST['status']
        ];

        // Validations
        if (empty($data['name']) || !preg_match("/^[A-Za-z\s]{2,50}$/", $data['name'])) {
            $error[] = "Name should be between 2-50 characters and contain only letters and spaces.";
        }
        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $error[] = "Please enter a valid email address.";
        }
        if (empty($data['phone']) || !preg_match("/^[0-9]{10}$/", $data['phone'])) {
            $error[] = "Phone number must be exactly 10 digits.";
        }
        if (empty($data['position'])) {
            $error[] = "Position is required.";
        }
        if (empty($data['department'])) {
            $error[] = "Department is required.";
        }
        if (empty($data['date_of_joining'])) {
            $error[] = "Date of joining is required.";
        }
        if (empty($data['address']) || !preg_match("/^[A-Za-z0-9\s,.-]{5,150}$/", $data['address'])) {
            $error[] = "Address is required and should be between 5-150 characters.";
        }
        if (empty($error)) {
           

            $isAdded = $dashboardModel->addEmployee($data);

            if ($isAdded) {
                header("Location:/admin_employees");
                exit();
            } else {
                $error[] = "Error occurred while adding the employee.";
            }
        }
    }
    $managers = $dashboardModel->getEmployees(['role' => 3]);
    $roles = [0 => 'Employee', 1 => 'Admin', 2 => 'HR', 3 => 'Manager'];
    $this->view('admin/addemployee', [
        'managers' => $managers,
        'roles' => $roles,
        'error' => $error
    ]);
}


//edit employee function
    public function editEmployee()
    {
        Auth::requireRole([1]);

        $dashboardModel = $this->model('AdminDashboard');

        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location:/admin_employees");
            exit();
        }

        $employee = $dashboardModel->getById('employees', (int)$id);

        if (!$employee) {
            echo "Employee not found!";
            exit();
        }

        $error = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => htmlspecialchars($_POST['name']) ?? '',
                'email' => $_POST['email'] ?? '',
                'phone' => $_POST['phone'] ?? '',
                'role' => $_POST['role'] ?? 0,
                'position' => htmlspecialchars($_POST['position']) ?? '',
                'department' => $_POST['department'] ?? '',
                'manager_id' => $_POST['manager_id'] ?? null,
                'status' => $_POST['status'] ?? 1
            ];

            if (empty($data['name']) || !preg_match("/^[A-Za-z\s]{4,50}$/", $data['name'])) {
                $error[] = "Name must be 2-50 letters only.";
            }
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $error[] = "Invalid email.";
            }
            if (!preg_match("/^[0-9]{10}$/", $data['phone'])) {
                $error[] = "Phone must be 10 digits.";
            }
            if (empty($data['position'])) $error[] = "Position is required.";
            if (empty($data['department'])) $error[] = "Department is required.";

            if (empty($error)) {
                $dashboardModel->updateEmployee($id, $data);
                header("Location:/admin_employees");
                exit();
            }
        }

        $managers = $dashboardModel->getEmployees(['role' => 3]);

        $roles = [0 => 'Employee', 1 => 'Admin', 2 => 'HR', 3 => 'Manager'];

        $this->view('admin/editemployee', [
            'employee' => $employee,
            'managers' => $managers,
            'roles' => $roles,
            'error' => $error
        ]);
    }

    //add salary
    public function addsalary(){
        Auth::requireRole([1,2]);
        $error = [];
        $dashboardModel = $this->model('AdminDashboard'); 
        if (isset($_POST['submit'])) {
            $employee_id = $_POST['employee_id'];
            $basic_salary = $_POST['basic_salary'];
            $hra = $_POST['hra'];
            $deductions = $_POST['deductions'];

            if (empty($employee_id) || empty($basic_salary) || empty($hra) || empty($deductions)) {
                $error[] = "All fields are required!";
            } elseif (!is_numeric($basic_salary) || $basic_salary <= 0) {
                $error[] = "Basic Salary must be a positive number!";
            } elseif (!is_numeric($hra) || $hra < 0) {
                $error[] = "HRA must be a valid non-negative number!";
            } elseif (!is_numeric($deductions) || $deductions < 0) {
                $error[] = "Deductions must be a valid non-negative number!";
            } else {
                if ($dashboardModel->checkSalaryExists($employee_id)) {
                    $error[] = "Salary structure already exists for this employee!";
                }
            }
            $max_basic_salary_value = 1000000; 
        $max_hra_value = 999999.99; 
        $max_deductions_value = 500000; 
        if ($basic_salary > $max_basic_salary_value) {
            $error[] = "Basic Salary is too large.";
        }
        if ($hra > $max_hra_value) {
            $error[] = "HRA value is too large.";
        }
        if ($deductions > $max_deductions_value) {
            $error[] = "Deductions value is too large.";
        }

            if (empty($error)) {
                $success = $dashboardModel->addsalary($employee_id, $basic_salary, $hra, $deductions);
                if ($success) {
                    header("Location:/salarystructure"); 
                    exit();
                } else {
                    $error[] = "Database Error: " . $dashboardModel->getLastError();
                }
            }
        }
        $employees = $dashboardModel->getAllEmployees();
        $this->view('admin/addsalary', [
            'error' => $error,
            'employees' => $employees
        ]);
    }

    }
?>
