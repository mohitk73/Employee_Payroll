
<head>
    <link rel="stylesheet"  href="../assets/css/employees.css">
    <link rel="stylesheet" href="../assets/css/pagination.css">
</head>
<main>
    <section>
            <h2>Employees</h2>
        <a class="backdashboard"  href="/manager/dashboard"> Back to Dashboard</a><br><br>
                <form method="GET" class="filter">
               <input type="text" name="name" placeholder="Search by name"
                  value="<?= isset($_GET['name']) ? htmlspecialchars($_GET['name']) : '' ?>"  onchange="this.form.submit()">

    <select name="department" onchange="this.form.submit()">
        <option value="">All Departments</option>
        <?php
        $departments = ["HR", "Sales", "IT"]; 
        foreach ($departments as $dept) {
            $selected = (isset($_GET['department']) && $_GET['department'] == $dept) ? "selected" : "";
            echo "<option value='$dept' $selected>$dept</option>";
        }
        ?>
    </select>

    <select name="status" onchange="this.form.submit()">
        <option value="">All Status</option>
        <option value="1" <?= (isset($_GET['status']) && $_GET['status'] === "1") ? "selected" : "" ?>>Active</option>
        <option value="0" <?= (isset($_GET['status']) && $_GET['status'] === "0") ? "selected" : "" ?>>Inactive</option>
    </select>
</form>

                <table border="1" cellpadding="8" cellspacing="0">
                    <tr>
                        <th>S.no</th>
                        <th>Emp_Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Position</th>
                        <th>Department</th>
                        <th>Date of Joining</th>
                        <th>Address</th>
                        <th>Status</th>
                    </tr>
                    <?php if(!empty($results)){?>
                        <?php $sn=1; ?>
                    <?php foreach($results as $row){ ?>
                        
                        <tr>
                            <td><?= $sn++ ?></td>
                            <td><?= $row['id'] ?></td>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= $row['email'] ?></td>
                            <td><?= $row['phone'] ?></td>
                            <td><?= $row['position'] ?></td>
                            <td><?= $row['department'] ?></td>
                            <td><?= $row['date_of_joining'] ?></td>
                            <td><?= $row['address'] ?></td>

                            <td>
                                <span class="status-badge <?= $row['status'] == 1 ? 'active' : 'inactive' ?>">
                                    <?= $row['status'] == 1 ? "Active" : "Inactive" ?>
                                </span>
                            </td>
                            <?php } ?>
                        </tr>
                    <?php } else{?>
                          <tr>
                           <td colspan="12" style="text-align:center;">No Record Found!</td>
                         </tr>
                        <?php }?>
                    

                </table>
                <?php include '../app/views/layout/pagination.php' ?>
    </section>
</main>