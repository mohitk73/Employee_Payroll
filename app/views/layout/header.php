<?php
use App\Helpers\Session;
$activepage = $_GET['route'] ?? "";
Session::start();
?>
<!DOCTYPE html>
<html>

<head>
    <title>
        <?php 
        if (Session::get('role')== 1) {
            echo "Admin Dashboard - Mind2Web Payroll";
        }  elseif(Session::get('role')==0) {
            echo "Employee dashboard";
        }
        elseif(Session::get('role')==2) {
            echo "HR dashboard";
        }
        else{
              echo "Manager Dashboard";
        }
        ?>
    </title>
    <link rel="stylesheet" type="text/css" href="../assets/css/header.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="sidebar">
        <h1><i class="fas fa-file-invoice-dollar"></i>Mind2Web Payroll</h1>
        <?php if (Session::get('role') == 1) { ?>
             <a href="/admin_dashboard" class="<?= $activepage == 'admin_dashboard' ? 'active' : '' ?>">Dashboard</a>
    <a href="/admin_employees" class="<?= $activepage == 'admin_employees' ? 'active' : '' ?>">Employees</a>
    <a href="/admin_attendance" class="<?= $activepage == 'admin_attendance' ? 'active' : '' ?>">Attendance</a>
    <a href="/salarystructure" class="<?= $activepage == 'salarystructure' ? 'active' : '' ?>">Salary Structure</a>
    <a href="/payroll" class="<?= $activepage == 'payroll' ? 'active' : '' ?>">Payroll</a>
    <a href="/payslips" class="<?= $activepage == 'payslips' ? 'active' : '' ?>">Payslips</a>
    <a href="/queries" class="<?= $activepage == 'queries' ? 'active' : '' ?>">Employee Queries</a>
    <a href="/logout" class="logout">Logout</a>
        <?php } ?>

        <?php if (Session::get('role') == 2) { ?>
            <a href="/hr/dashboard" class="<?= $activepage == '/hr/hrdashboard' ? 'active' : '' ?>">Dashboard</a>
            <a href="/hr/employees" class="<?= $activepage == '/hr/employees' ? 'active' : '' ?>">Employees</a>
            <a href="/hr/attendance" class="<?= $activepage == '/hr/attendance' ? 'active' : '' ?>">Attendance</a>
            <a href="/hr/salarystructure" class="<?= $activepage == '/hr/salarystructure' ? 'active' : '' ?>">Salary Structure</a>
            <a href="/hr/payroll" class="<?= $activepage == '/hr/payroll' ? 'active' : '' ?>">Payroll</a>
            <a href="/hr/payslips" class="<?= $activepage == '/hr/payslips' ? 'active' : '' ?>">Payslips</a>
            <a href="/logout" class="logout">Logout</a>
        <?php } ?>

        <?php if (Session::get('role') == 3) { ?>
            <a href="/manager/dashboard" class="<?= $activepage == 'manager/dashboard' ? 'active' : '' ?>">Dashboard</a>
            <a href="/manager/employees" class="<?= $activepage == 'manager/employees' ? 'active' : '' ?>">Employees List</a>
            <a href="/manager/attendance" class="<?= $activepage == 'manager/attendance' ? 'active' : '' ?>">Attendance</a>
            <a href="/manager/managerpayslip" class="<?= $activepage == 'manager/payslip' ? 'active' : '' ?>"> Your Payslip</a>
            <a href="/manager/contactsupport" class="<?= $activepage == 'manager/contactsupport' ? 'active' : '' ?>">Contact Support</a>
            <a href="/logout" class="logout" class="<?= $activepage == '/logout' ? 'active' : '' ?>">Logout</a>
        <?php } ?>

        <?php if (Session::get('role') == 0) { ?>
            <a href="/employee/dashboard" class="<?= $activepage == 'employee/dashboard' ? 'active' : '' ?>">Dashboard</a>
            <a href="/employee/attendance" class="<?= $activepage == 'employee/attendance' ? 'active' : '' ?>">Attendance</a>
            <a href="/employee/emppayslip" class="<?= $activepage == 'employee/emppayslip' ? 'active' : '' ?>">Payslips</a>
            <a href="/employee/contactsupport" class="<?= $activepage == 'employee/contactsupport' ? 'active' : '' ?>">Contact Support</a>
            <div>
                <a href="/logout" class="logout">Logout</a>
            </div>
        <?php } ?>
    </div>
    <main>
        <header>

            <div>
               
            </div>
            <div class="nav">
                <h2>Welcome <?= Session::get('name') ?>!</h2>
                <i onclick="menu(event)" class="fas fa-bars"></i>

                <div class="profile">
                    <nav>
                        <ul>
                            <li><a href="/profile">View Profile</a></li>
                            <?php if($_SESSION['role']==1){ ?><li><a href="/queries">View Queries</a></li><?php } else{?>
                                <li><a href="/employee/contactsupport">Get Help</a></li><?php }?>
                            <li><a href="/logout">Logout</a></li>
                        </ul>
                    </nav>
                </div>
            </div>


        </header>

    </main>
    <script>
        function menu(event) {
            const profile = document.querySelector('.profile');

            if (profile.style.display === "block") {
                profile.style.display = "none";
            } else {
                profile.style.display = "block";
            }
        }
    </script>


</body>

</html>