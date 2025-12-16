<head>
    <title>Manager Dashboard</title>
    <link rel=stylesheet href="../assets/css/empdashboard.css">
</head>
<main>
    <section>
        <div class="welcome">
            <h3>Welcome, <?php echo $_SESSION['name']; ?>!</h3>
        </div>

        <div>
            <div class="attendance">
                <h4>Employees Attendance Summary</h4>
            </div>
            <div class="attendance-summary">
                <div class="attendancedetails">
                    <div>
                        <h4>Total employees</h4>
                        <p><?= $totalemp ?> </p>
                    </div>
                    <hr>
                    <div>
                        <h4>Present Today</h4>
                        <p><?= $present ?></p>
                    </div>
                    <hr>
                    <div>
                        <h4>Absent Today</h4>
                        <p><?= $absent ?></p>
                    </div>
                    <div class="attreports">
                        <a href="/manager/attendance">View Details</a>
                        <p></p>
                    </div>
                </div>

            </div>
        </div>
        <div class="notice">
            <h4>Announcements</h4>
        </div>
        <div class="notification">
            <h4>Upcoming Events</h4>
            <div class="festival">
                <div class="festivelist">
                    <?php $count = 0; ?>
                    <?php if (!empty($holidays)) { ?>
                        <?php foreach ($holidays as $event) { ?>
                            <?php
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

            </div>
        </div>
    </section>
</main>