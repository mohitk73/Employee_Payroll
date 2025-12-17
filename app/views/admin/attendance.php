
<head>
    <link rel="stylesheet" href="../assets/css/attendance.css">
    <link rel="stylesheet" href="../assets/css/pagination.css">
</head>

<main>
    <section>
        <h3>Attendance - <?= $date ?></h3>
        <form method="GET" class="attendance-filter">
             <input type="hidden" name="route" value="admin_attendance">
            <input type="date" name="date" value="<?= $date ?>" onchange="this.form.submit()">
            <input type="text" name="name" placeholder="Search by name" value="<?= htmlspecialchars($name) ?>" onchange="this.form.submit()">
            <select name="status" onchange="this.form.submit()">
                <option value="">All Status</option>
                <option value="1" <?= ($status === "1") ? "selected" : "" ?>>Present</option>
                <option value="0" <?= ($status === "0") ? "selected" : "" ?>>Absent</option>
                <option value="null" <?= ($status === "null") ? "selected" : "" ?>>Not Marked</option>
            </select>
        </form>

        <table class="attendance-table">
            <tr>
                <th>Employee Id</th>
                <th>Name</th>
                <th>Position</th>
                <th>Status</th>
                <th>Action</th>
                <th>Marked At</th>
            </tr>

            <?php if (!empty($employees)) { ?>
                <?php foreach ($employees as $row) { ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['name'] ?></td>
                        <td><?= $row['position'] ?></td>

                        <td>
                            <?php if ($row['status'] === NULL) { ?>
                                <span class="badge gray">Not Marked</span>
                            <?php } elseif ($row['status'] == 1) { ?>
                                <span class="badge green">Present</span>
                            <?php } else { ?>
                                <span class="badge red">Absent</span>
                            <?php } ?>
                        </td>

                        <td>
                            <?php if ($row['status'] === NULL) { ?>
                                <a href="/mark_attendance?emp_id=<?= $row['id'] ?>&status=1" class="btn green">Present</a>
                                <a href="/mark_attendance?emp_id=<?= $row['id'] ?>&status=0" class="btn red">Absent</a>
                            <?php } else { ?>
                                <span class="badge gray">Already Marked</span>
                            <?php } ?>
                        </td>

                        <td><?= $row['created_at'] ?></td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="6" style="text-align:center;">No Record Found!</td>
                </tr>
            <?php } ?>
        </table>
        <?php include '../app/views/layout/pagination.php' ?>


    </section>
</main>