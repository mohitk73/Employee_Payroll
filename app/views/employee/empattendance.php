
<head>
    <link rel="stylesheet" href="../assets/css/empattendance.css">
    <link rel="stylesheet" href="../assets/css/pagination.css">

    <title>Employee Attendance page</title>
</head>
<main>
    <section>
        <h3>Your Attendance - <span><?= $today ?></span></h3>
        <div class="status">
            <h4>Today's Attendance Status : <p class="status"><?php if(!empty($todayattendance) && $todayattendance['status']=='1'){ ?>
                        <span style="background-color: green;">Present</span>
                        <?php } else{?>
                            <span style="background-color: red;">Absent</span>
                            <?php } ?>
                    </p>
            </h4>
            </h4>
        </div>

        <div class="summary">
            <h4>Attendance Summary</h4>
            <div class="summary-details">
                <div class="card">
                    <h3>Total Working Days</h3>
                    <h4><?= $totalworking ?></h4>
                </div>
                <div class="card">
                    <h3>Total Present Days</h3>
                    <h4><?= $present ?></h4>
                </div>
                <div class="card">
                    <h3>Total Absent Days</h3>
                    <h4><?= $absent ?></h4>
                </div>
                <div class="card">
                    <h3>Attendance Percentage</h3>
                    <h4><?= $percentage ?> %</h4>

                </div>
            </div>
        </div>
        <div class="attendance-history">
            <h4>Attendance History</h4>
            <div class="attendance-filter">
                <form method="GET" class="filter">
                    <div>
                        <label>From:</label>
                        <input type="date" name="from" value="<?= $_GET['from'] ?? '' ?>" onchange="this.form.submit()">
                    </div>
                    <div>
                        <label>to:</label>
                        <input type="date" name="to" value="<?= $_GET['to'] ?? '' ?>"onchange="this.form.submit()">
                    </div>
                    <div>
                        <label>Status:</label>
                        <select name="status" onchange="this.form.submit()">
                            <option value="">All</option>
                            <option value="1" <?= (($_GET['status'] ?? '') == '1') ? 'selected' : '' ?>>Present</option>
                            <option value="0" <?= (($_GET['status'] ?? '') == '0') ? 'selected' : '' ?>>Absent</option>
                        </select>
                    </div>
                </form>
            </div>
            <table class="attendance-table">
                <tr>
                    <th>S.No</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Marked At</th>
                </tr>

                <?php if(count($history)>0) { ?>
                    <?php foreach($history as $his){?>
                    <tr>
                        <td><?= $sn++ ?></td>
                        <td><?= $his['date'] ?></td>
                        <td>
                            <?php if ($his['status'] == 1) { ?>
                                <span class="present">Present</span>
                            <?php } else { ?>
                                <span class="absent">Absent</span>
                            <?php } ?>
                        </td>
                        <td><?= $his['created_at'] ?></td>
                    </tr>
                    <?php }?>
                <?php } else{?>
                    <td colspan="12">No Record Found !</td>
                    <?php }?>

            </table>
              <?php include '../app/views/layout/pagination.php' ?>
        </div>
    </section>
</main>