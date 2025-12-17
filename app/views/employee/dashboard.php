
<head>
     <title>Employee Dashboard</title>
    <link rel=stylesheet href="../assets/css/empdashboard.css">
</head>
<main>
    <section>
        <div class="welcome">
            <h3>Welcome, <?php echo $_SESSION['name']; ?>!</h3>
        </div>

        <div>
            <div class="overview">
                <div>
                    <h4>Net Pay (Last Month)</h4>
                    <p><?= number_format($payrolldetails['net_salary'], 2) ?></p>
                </div>
                <div>
                    <h4>Attendance Percentage</h4>
                    <p><?= $attendancepercentage ?>%</p>
                </div>
                <div>
                    <h4>Next Salary Date</h4>
                    <p><?= $nextpaydate ?></p>
                </div>
            </div>

            <div class="last">
                <h4>Salary Summary <span>(Last Month : <?= date("F Y", strtotime($payrolldetails['month'])) ?>)</span></h4>
            </div>
            <div class="salary-summary">
                <div class="salarydetails">
                    <div>
                        <h4>Gross Earnings</h4>
                        <p><?= number_format($payrolldetails['gross_salary'], 2) ?></p>
                    </div>
                    <hr>
                    <div>
                        <h4>Deductions</h4>
                        <p><?= number_format($payrolldetails['deductions'], 2) ?></p>
                    </div>
                    <hr>
                    <div>
                        <h4>Net Pay</h4>
                        <p><?= number_format($payrolldetails['net_salary'], 2) ?></p>
                    </div>
                    <hr>
                    <div>
                        <h4>Pay Date</h4>
                        <p><?= $paydate ?></p>
                    </div>
                </div>
                <div class="latest">
                    <h4>View Recent Payslip <span>(<?= date("F Y",strtotime($payrolldetails['month'])) ?>)</span></h4>
                    <a href="/employee/emppayslip?month=<?= date("Y-m",strtotime($payrolldetails['month'])) ?>">View Payslip</a>

                </div>
            </div>

            <div class="attendance">
                <h4>Attendance Summary</h4>
            </div>
            <div class="attendance-summary">
                <div class="attendancedetails">
                    <div>
                        <h4>Total Working Days</h4>
                        <p><?= $totalworkingdays ?></p>
                    </div>
                    <hr>
                    <div>
                        <h4>Total Present Days</h4>
                        <p><?= $payrolldetails['presentdays'] ?></p>
                    </div>
                    <hr>
                    <div>
                        <h4>Total Absent Days</h4>
                        <p><?= $payrolldetails['absentdays'] ?></p>
                    </div>
                    <hr>
                    <div>
                        <h4>Attendance Percentage</h4>
                        <p><?= $attendancepercentage ?>%</p>
                    </div>
                    <div class="attreports">
                        <a href="/employee/attendance">View Details</a>
                        <p></p>
                    </div>
                </div>
                <div class="attendance-status">
                    <h4>Today's Attendance Status</h4>
                    <p class="status"><?php if(!empty($attendancestatus) && $attendancestatus['status']=='1'){ ?>
                        <span style="background-color: green;">Present</span>
                        <?php } else{?>
                            <span style="background-color: red;">Absent</span>
                            <?php } ?>
                    </p>
                </div>
            </div>
            <div class="notice">
                <h4>Announcements</h4>
            </div>
            <div class="notification">
                <h4>Upcoming Events</h4>
                <div class="festival">
                    <div class="festivelist">
                        <?php $count=0;?>
                        <?php if (!empty($holidays)) { ?>
                            <?php foreach ($holidays as $event) {
                                if ($event['date']['iso'] >= $today) { ?>
                                    <div>
                                        <h5><?= htmlspecialchars($event['name']) ?></h5>
                                        <p><?= htmlspecialchars(substr($event['date']['iso'], 0, 10)) ?></p>
                                    </div>
                        <?php $count++;
                                }
                                if ($count >= 4) break;
                            }
                            if ($count == 0) {
                                echo "<h5>No upcoming events found</h5>";
                            }
                        } else {
                            echo "no event found";
                        }
                        ?>
                    </div>
                    <div class="next-salary">
                        <h5>Next Salary Date</h5>
                        <p><?= $nextpaydate ?></p>
                    </div>
                </div>
            </div>

            <div class="query">
                <h3>Queries Record</h3>
                <div class="queries-table">
                    <table>
                        <thead>
                            <tr>
                                <th>S.no</th>
                                <th>Query Id</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                             <?php if (!empty($queries) && is_array($queries)) {?>
                                <?php $sn=1;?>
    <?php foreach($queries as $query) {?>
                            <tr>  
                                <td><?= $sn++ ?></td>
                                    <td><?= $query['id'] ?></td>
                                    <td><?= $query['subject'] ?></td>
                                    <td><?= $query['message'] ?></td>
                                    <td><?php if($query['status'] == 1) {?>
                                        <span style="color: green;">Resolved</span>
                                        <?php } else {?>
                                            <span style="color:red;">Pending</span>
                                            <?php }?>
                                        </td>
                            </tr>
                            <?php }?>
                            <?php } ?>
                        </tbody>
                    </table>

                </div>
            </div>
    </section>
</main>