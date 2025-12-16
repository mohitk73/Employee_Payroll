<head>
    <link rel="stylesheet" href="../assets/css/queries.css">
     <link rel="stylesheet" href="../assets/css/pagination.css">
</head>
<main>
    <section>
        <h3>Employee Queries</h3>
        <div class="filter">
            <form method="GET">
                     <input type="date" name="date" value="<?= $_GET['date'] ?? ''?>" onchange="this.form.submit()">
                <select name="status" onchange="this.form.submit()">
                    <option value="">All</option>
                    <option value="1" <?= (isset($_GET['status']) && $_GET['status']==='1' ? "selected":'') ?>>Resolved</option>
                        <option value="0" <?= (isset($_GET['status']) && $_GET['status']==='0' ? "selected":'') ?>>Pending</option>
                </select>
            </form>
        </div>
        <div class="employeequeries">
            <div class="querydata">
                <table>
                    <thead>
                        <tr>
                            <TH>S.no</TH>
                            <th>Employeee Id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    <tbody>
                         <?php if (!empty($queries)) { ?>
                <?php foreach ($queries as $query) { ?> 
                            <tr>
                                <td><?= $sn++ ?></td>
                                <td><?= $query['employee_id'] ?></td>
                                <td><?= htmlspecialchars($query['name']) ?></td>
                                <td><?= htmlspecialchars($query['email']) ?></td>
                                <td><?= htmlspecialchars($query['subject']) ?></td>
                                <td><?= htmlspecialchars($query['message']) ?></td>
                                <td><?= htmlspecialchars($query['created_at']) ?></td>
                                <td>
                                    <?php if ($query['status'] == 1) { ?>
                                        <span style="color: green; font-weight: bold;">Resolved</span>
                                    <?php } else { ?>
                                        <span style="color: red; font-weight: bold;">Pending</span>
                                    <?php } ?>
                                </td>

                                <td>
                                    <?php if ($query['status'] == 0) { ?>
                                        <form method="post">
                                            <input type="hidden" name="id" value="<?= $query['id'] ?>">
                                            <button type="submit" name="resolve">Resolve</button>
                                        </form>
                                    <?php } else { ?>
                                        <button disabled>Resolved</button>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                        <?php } else{?>
                        <tr>
                            <td colspan="12" style="text-align: center;">
                                No Records Found!
                            </td>
                        </tr>
                        <?php }?>

                    </tbody>
                    </thead>
                </table>
                <?php include '../app/views/layout/pagination.php' ?>

            </div>
            
        </div>
    </section>
</main>