<head>
    <link rel="stylesheet" href="../assets/css/payroll.css" >
    <link rel="stylesheet" href="../assets/css/pagination.css" >
</head>
<main>
<section>
    <h3>Payroll Management</h3>
    <?php if(!empty($msg)) { echo '<p style="color:green;">'.$msg.'</p>'; } ?><br>

    <form method="post" action="">
        <label>Select Month:</label>
        <input type="month" name="month" value="<?= $filtermonth ?>" required>
        <input type="submit" name="generate" value="Generate Payroll">
    </form>

    <h4>Payroll Records for <?= date('F Y', strtotime("$filtermonth-01")) ?></h4>
    <table border="1" cellpadding="10">
        <tr>
            <th>Month</th>
            <th>Employee Id</th>
            <th>Name</th>
            <th>Department</th>
            <th>Basic Salary</th>
            <th>Hra</th>
            <th>Total Working Days</th>
            <th>Total Present Days</th>
            <th>Total Absent Days</th>
            <th>Gross Salary</th>
            <th>Deductions</th>
            <th>Net Salary</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php if($payroll_result->num_rows > 0): ?>
            <?php while($row = $payroll_result->fetch_assoc()): ?>
            <tr>
                <td><?= date('F Y', strtotime($row['month'])) ?></td>
                <td><?= $row['employee_id'] ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= $row['department'] ?></td>
                <td><?= number_format($row['basic_salary'], 2) ?></td>
                <td><?= number_format($row['hra'], 2) ?></td>
                <td><?= $row['present_days'] + $row['absent_days'] ?></td>
                <td><?= $row['present_days'] ?></td>
                <td><?= $row['absent_days'] ?></td>
                <td><?= number_format($row['gross_salary'], 2) ?></td>
                <td><?= number_format($row['deductions'], 2) ?></td>
                <td><?= number_format($row['net_salary'], 2) ?></td>
                <td><?= $row['status'] == 1 ? 'Paid' : 'Unpaid' ?></td>
                <td>
                    <div style="display: flex; gap:10px; justify-content:center;">
                        <a href="/payslip?emp=<?= $row['employee_id'] ?>&month=<?= $row['month'] ?>">Payslip</a>
                        <?php if($row['status']==0): ?>
                        <a href="?month=<?= $filtermonth ?>&payroll_id=<?= $row['payroll_id'] ?>&pay=1">Mark Paid</a>
                        <?php else: ?>
                        <button disabled>Paid</button>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="14" style="text-align:center;">No Records Found!</td></tr>
        <?php endif; ?>
    </table>

    <div class="pagination">
        <nav>
        <ul>
            <?php if($page>1): ?>
            <li><a href="/payroll?month=<?= $filtermonth ?>&page=<?= $page-1 ?>">Previous</a></li>
            <?php endif; ?>
            <?php for($i=1;$i<=$totalpages;$i++): ?>
            <li class="<?= ($i==$page)?'active':'' ?>"><a href="/payroll?month=<?= $filtermonth ?>&page=<?= $i ?>"><?= $i ?></a></li>
            <?php endfor; ?>
            <?php if($page<$totalpages): ?>
            <li><a href="/payroll?month=<?= $filtermonth ?>&page=<?= $page+1 ?>">Next</a></li>
            <?php endif; ?>
        </ul>
        </nav>
    </div>
</section><br>
<a class="back" href="/admin_dashboard"><- Back To Dashboard</a>
</main>
