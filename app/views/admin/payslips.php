<head>
    <link rel="stylesheet" href="../assets/css/payslips.css">
    <link rel="stylesheet" href="../assets/css/pagination.css">
</head>
<main>
    <section>
        <div class="formdata">
            <form method="get" class="form">
                <label>Select Month:</label>
               <input type="month" name="month" required value="<?= isset($_GET['month']) ? $_GET['month'] : '' ?>">
                <button type="submit">Generate Payslips</button>
            </form>
        </div>
        <div class="allpayslip">
        <h3>All Pay Slips<?= isset($_GET['month']) ? " for " . date('F Y', strtotime($_GET['month'])) : '' ?></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th>S.no</th>
                        <th>Payslip Id</th>
                        <th>Month</th>
                        <th>Employee Id</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($_GET['month'])){?>
                          <?php if (!empty($payslips)) { ?>
                             <?php $sn = ($page - 1) * 5 + 1; ?>
                <?php foreach ($payslips as $payslip) { ?>
                    <tr>
                        <td><?= $sn++ ?></td>
                        <td><?= $payslip['payslip_id'] ?></td>
                        <td><?= date('F Y', strtotime($payslip['month'])); ?></td>
                        <td><?= $payslip['id'] ?></td>
                        <td><?= htmlspecialchars($payslip['name']) ?></td>
                        <td>
                            <a class="slip" href="/payslip?emp=<?= $payslip['employee_id'] ?>&month=<?= ($payslip['month']) ?>">View Payslip</a>
                        </td>
                    </tr>
                    <?php }?>
                    <?php } else{?>
                        <tr>
                            <td colspan="12" style="text-align: center;">
                                No Records Found!
                            </td>
                        </tr>
                        <?php }?>
                        <?php } else{?>
                             <tr>
                            <td colspan="12" style="text-align: center;">
                                No Records Found!
                            </td>
                        </tr>
                            <?php }?>
                </tbody>
            </table>
            <div class="pagination">
        <nav>
        <ul>
            <?php if($page>1): ?>
            <li><a href="/payslips?month=<?= $month ?>&page=<?= $page-1 ?>">Previous</a></li>
            <?php endif; ?>
            <?php for($i=1;$i<=$totalpages;$i++): ?>
            <li class="<?= ($i==$page)?'active':'' ?>"><a href="/payslips?month=<?= $month ?>&page=<?= $i ?>"><?= $i ?></a></li>
            <?php endfor; ?>
            <?php if($page<$totalpages): ?>
            <li><a href="/payslips?month=<?= $month ?>&page=<?= $page+1 ?>">Next</a></li>
            <?php endif; ?>
        </ul>
        </nav>
    </div>
        </div>  
    </section>
</main>