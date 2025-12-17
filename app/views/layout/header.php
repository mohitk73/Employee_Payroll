<?php

use App\Helpers\Session;

Session::start();
$activepage = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

?>
<!DOCTYPE html>
<html>

<head>
    <title>
        <?php
        if (Session::get('role') == 1) {
            echo "Admin Dashboard - Mind2Web Payroll";
        } elseif (Session::get('role') == 0) {
            echo "Employee dashboard";
        } elseif (Session::get('role') == 2) {
            echo "HR dashboard";
        } else {
            echo "Manager Dashboard";
        }
        ?>
    </title>
    <link rel="stylesheet" type="text/css" href="../assets/css/header.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="sidebar">
        <div>
            <h1><i class="fas fa-file-invoice-dollar"></i>Mind2Web Payroll</h1>
        
        <?php if (Session::get('role') == 1) { ?>
            <div>
                <a href="/admin_dashboard" class="<?= $activepage == 'admin_dashboard' ? 'active' : '' ?>">Dashboard</a>
                <a href="/admin_employees" class="<?= $activepage == 'admin_employees' ? 'active' : '' ?>">Employees</a>
                <a href="/admin_attendance" class="<?= $activepage == 'admin_attendance' ? 'active' : '' ?>">Attendance</a>
                <a href="/salarystructure" class="<?= $activepage == 'salarystructure' ? 'active' : '' ?>">Salary Structure</a>
                <a href="/payroll" class="<?= $activepage == 'payroll' ? 'active' : '' ?>">Payroll</a>
                <a href="/payslips" class="<?= $activepage == 'payslips' ? 'active' : '' ?>">Payslips</a>
                <a href="/queries" class="<?= $activepage == 'queries' ? 'active' : '' ?>">Employee Queries</a>
            </div>
            </div>
        <?php } ?>

        <?php if (Session::get('role') == 2) { ?>
        <div>
            <a href="/hr/dashboard" class="<?= $activepage == 'dashboard' ? 'active' : '' ?>">Dashboard</a>
            <a href="/hr/employees" class="<?= $activepage == 'employees' ? 'active' : '' ?>">Employees</a>
            <a href="/hr/attendance" class="<?= $activepage == 'attendance' ? 'active' : '' ?>">Attendance</a>
            <a href="/hr/salarystructure" class="<?= $activepage == 'salarystructure' ? 'active' : '' ?>">Salary Structure</a>
            <a href="/hr/payroll" class="<?= $activepage == 'payroll' ? 'active' : '' ?>">Payroll</a>
            <a href="/hr/payslips" class="<?= $activepage == 'payslips' ? 'active' : '' ?>">Payslips</a>
        </div>
        </div>
       
        <?php } ?>

        <?php if (Session::get('role') == 3) { ?>
        <div>
            <a href="/manager/dashboard" class="<?= $activepage == 'dashboard' ? 'active' : '' ?>">Dashboard</a>
            <a href="/manager/employees" class="<?= $activepage == 'employees' ? 'active' : '' ?>">Employees List</a>
            <a href="/manager/attendance" class="<?= $activepage == 'attendance' ? 'active' : '' ?>">Attendance</a>
            <a href="/manager/managerpayslip" class="<?= $activepage == 'payslip' ? 'active' : '' ?>"> Your Payslip</a>
            <a href="/manager/contactsupport" class="<?= $activepage == 'contactsupport' ? 'active' : '' ?>">Contact Support</a>
        </div>
        </div>
       
        <?php } ?>

        <?php if (Session::get('role') == 0) { ?>
            <div>
                <a href="/employee/dashboard" class="<?= $activepage == 'dashboard' ? 'active' : '' ?>">Dashboard</a>
                <a href="/employee/attendance" class="<?= $activepage == 'attendance' ? 'active' : '' ?>">Attendance</a>
                <a href="/employee/emppayslip" class="<?= $activepage == 'emppayslip' ? 'active' : '' ?>">Payslips</a>
                <a href="/employee/contactsupport" class="<?= $activepage == 'contactsupport' ? 'active' : '' ?>">Contact Support</a>
            </div>
            </div>
        <?php } ?>
         <div>
                <a href="/logout" class="logout">Logout</a>
            </div>
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
                            <?php if ($_SESSION['role'] == 1) { ?><li><a href="/queries">View Queries</a></li><?php } else { ?>
                                <li><a href="/employee/contactsupport">Get Help</a></li><?php } ?>
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