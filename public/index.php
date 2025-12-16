<?php

require_once __DIR__ . '/../app/config/bootstrap.php';
use App\Core\Router;
use App\Controllers\LoginController;
use App\Controllers\DashboardController;
use App\Controllers\LogoutController;
use App\Controllers\AttendanceMark;
use App\Controllers\ContactController;
use App\Controllers\EmployeeController;
use App\Controllers\SalaryController;
use App\Controllers\PayrollController;
use App\Controllers\PayslipController;
use App\Controllers\ProfileController;
use App\Controllers\QueriesController;
use App\Controllers\EmpattendanceController;
use App\Controllers\EmployeeslipController;
use App\Controllers\ManagerController;
use App\Helpers\Session;

Session::start();
$router = new Router();

//routes

// auth
$router->get('/', [LoginController::class, 'index']);
$router->get('/login', [LoginController::class, 'index']);
$router->post('/auth', [LoginController::class, 'auth']);
$router->get('/logout', [LogoutController::class, 'index']);
//dashboard
$router->get('/admin_dashboard', [DashboardController::class, 'admin']);

//employees list
$router->get('/admin_employees', [DashboardController::class, 'employees']);
$router->get('/editemployee', [DashboardController::class, 'editEmployee']);
$router->post('/editemployee', [DashboardController::class, 'editEmployee']);
$router->get('/addemployee', [DashboardController::class, 'addEmployee']);
$router->post('/addemployee', [DashboardController::class, 'addEmployee']);
$router->get('/deleteemployee', [DashboardController::class, 'employees']);

//salry structure
$router->get('/addsalary', [DashboardController::class, 'addsalary']);
$router->post('/addsalary', [DashboardController::class, 'addsalary']);
$router->get('/updatesalary', [SalaryController::class, 'update']);
$router->post('/updatesalary', [SalaryController::class, 'update']);
$router->get('/salarystructure', [SalaryController::class, 'index']);
$router->get('/salarystructure/ajax-search', [SalaryController::class, 'search']);

//payroll genaration
$router->get('/payroll', [PayrollController::class, 'index']);
$router->post('/payroll', [PayrollController::class, 'index']);

//attendance mark
$router->get('/admin_attendance', [AttendanceMark::class, 'index']);
$router->get('/mark_attendance', [AttendanceMark::class, 'mark']);

$router->get('/hr/attendance', [AttendanceMark::class, 'index']);
$router->get('/mark_attendance', [AttendanceMark::class, 'mark']);

// Payslip genartion
$router->get('/payslip',[PayslipController::class,'index']);
$router->get('/payslips',[PayslipController::class,'payslips']);

//queries 
$router->get('/queries',[QueriesController::class,'queries']);
$router->post('/queries',[QueriesController::class,'queries']);

//Profile
$router->get('/profile',[ProfileController::class,'profile']);

//Employee-dashboard
$router->get('/employee/dashboard',[EmployeeController::class,'empdashboard']);

//employee-attendance
$router->get('/employee/attendance',[EmpattendanceController::class,'attendance']);

//employee payslip
$router->get('/employee/emppayslip',[EmployeeslipController::class,'index']);

//contact support
$router->get('/employee/contactsupport',[ContactController::class,'contact']);
$router->post('/employee/contactsupport',[ContactController::class,'contact']);

//Manager Module
$router->get('/manager/dashboard',[ManagerController::class,'index']);
$router->get('/manager/employees',[ManagerController::class,'employees']);
$router->get('/manager/attendance', [AttendanceMark::class, 'index']);
$router->get('/manager/contactsupport',[ContactController::class,'contact']);
$router->post('/manager/contactsupport',[ContactController::class,'contact']);
// payslip
$router->get('/manager/managerpayslip',[EmployeeslipController::class,'index']);



//hr module
$router->get('/hr/dashboard', [DashboardController::class, 'admin']);

$router->get('/hr/attendance', [AttendanceMark::class, 'index']);
$router->get('/hr/mark_attendance', [AttendanceMark::class, 'mark']);

$router->get('/hr/employees', [DashboardController::class, 'employees']);
$router->get('/hr/editemployee', [DashboardController::class, 'editEmployee']);
$router->post('/hr/editemployee', [DashboardController::class, 'editEmployee']);
$router->get('/hr/addemployee', [DashboardController::class, 'addEmployee']);
$router->post('/hr/addemployee', [DashboardController::class, 'addEmployee']);
$router->get('/hr/deleteemployee', [DashboardController::class, 'employees']);

//salary

$router->get('/hr/addsalary', [DashboardController::class, 'addsalary']);
$router->post('/hr/addsalary', [DashboardController::class, 'addsalary']);
$router->get('/hr/salarystructure', [SalaryController::class, 'index']);

$router->get('/hr/payroll', [PayrollController::class, 'index']);
$router->get('/hr/payslip',[PayslipController::class,'index']);
$router->get('/hr/payslips',[PayslipController::class,'payslips']);

$router->get('/payslip/downloadPayslip',[PayslipController::class,'downloadPayslip']);

$router->dispatch();
