<?php
use App\Helpers\Session;

?>
<head>
   <link rel="stylesheet" type="text/css" href="../assets/css/admindashboard.css">
</head>
<main>
<section>
    <div class="welcome">
       <h3>Welcome, <?= Session::get('name') ?>!</h3>
<h4>Role: <?= $role[Session::get('role')] ?></h4>
    </div>

    <div class="payrun">
        <div class="processpayrun">
            <h3>Process Pay Run for <span><?= date('F Y', strtotime($month_start)) ?></span></h3>
            <div class="payrundetails">
                <div class="netpay">
                    <div>
                        <h4>Employees Net Pay</h4>
                        <p><?= number_format($payrollData['totalsalary'], 2) ?></p>
                    </div><hr>
                    <div>
                        <h4>Payment Date</h4>
                        <p><?= date('d/m/Y', strtotime($month_end)) ?></p>
                    </div><hr>
                    <div>
                        <h4>No. of Employees</h4>
                        <p><?= $payrollData['totalemployee'] ?></p>
                    </div><hr>
                    <div>
                        <a href="/payroll?month=<?= date('Y-m', strtotime($month_start)) ?> ">View Details</a>
                    </div>
                </div>
                <div class="pay">
                    <p>Pay your employees on <span><?= date('d/m/Y', strtotime($month_end)) ?></span>. Record it here</p>
                </div>
            </div>

            <div class="deduction">
                <div class="deduction-summary">
                    <div>
                        <h4>Deduction Summary</h4>
                        <p>Previous Month <span>(<?= date('F Y', strtotime($month_start)) ?>)</span></p>
                    </div>
                    <div class="tds">
                        <div>
                            <h4>Professional tax</h4>
                            <p>200</p>
                            <a href="/payroll?month=<?= date('Y-m', strtotime($month_start)) ?>">View Details</a>
                        </div><hr>
                        <div>
                            <h4>Leave Deduction</h4>
                            <p><?= $deductionData['absentdeduction'] ?? 0 ?></p>
                           <a href="/payroll?month=<?= date('Y-m', strtotime($month_start)) ?>">View Details</a>
                        </div><hr>
                        <div>
                            <h4>Total Deduction</h4>
                            <p><?= number_format($deductionData['totaldeduction'], 2) ?></p>
                            <a href="/payroll?month=<?= date('Y-m', strtotime($month_start)) ?>">View Details</a>
                        </div>
                    </div>
                </div>

                <div class="employee-summary">
                    <div><h4>Employees Summary</h4></div>
                    <div>
                        <h4>Active Employees</h4>
                        <p><?= $activeEmployeeData['totalactive'] ?></p>
                        <a href="/admin_employees">View Employees</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="todotask">
            <h3>To do tasks</h3>
            <div class="pending">
                <div>
                    <h4>Mark Employee Attendance</h4>
                    <p>
                        <?php if ($attendanceMarked['total'] <= 0) { ?>
                            <span style="color: red;">Pending</span>
                        <?php } else { ?>
                            <span style="color: green;">Already Marked</span>
                        <?php } ?>
                    </p>
                    <a href="/admin_attendance">Mark Attendance</a>
                </div>
                <div>
                    <h4>Salary Revision</h4>
                    <p>Update Salary</p>
                    <a href="/updatesalary">Update</a>
                </div>
            </div>
        </div>
    </div>

    <div class="attendance">
        <h3>Attendance Summary</h3>
        <div class="attendance-summary">
            <div>
                <h4>Total Employees</h4>
               <p><?= $activeEmployeeData['totalactive'] ?></p>
            </div><hr>
            <div>
                <h4>Present Today</h4>
                <p><?= $attendanceData['totalpresent'] ?></p>
            </div><hr>
            <div>
                <h4>Absent Today</h4>
                <p><?= $attendanceData['totalabsent'] ?></p>
            </div><hr>
            <div>
                <a href="/admin_attendance">View Details</a>
            </div>
        </div>
    </div>

    <div class="upcomingevents">
        <h3>Upcoming Events</h3>
        <div class="festival">
              <div class="festivallist">
                <?php $count=0; ?>
                        <?php if(!empty($holidays)) {?>
                            <?php foreach($holidays as $event) {
                                if ($event['date']['iso'] >= $today) {?>
                        <div>
                            <h5><?= htmlspecialchars($event['name']) ?></h5>
                            <p><?= htmlspecialchars(substr($event['date']['iso'], 0, 10)) ?></p>
                             </div>
                            <?php $count++;
                        } if($count>=4) break;}
                         if ($count == 0) {
            echo "<h5>No upcoming events found</h5>";
        } }
                         else{
                            echo "no event found";
                             }
                             ?>
                    </div>

        </div>
    </div>
</section>
</main>
