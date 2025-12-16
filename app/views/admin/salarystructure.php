
<head>
    <link rel="stylesheet" href="../assets/css/salarystructure.css">
    <link rel="stylesheet" href="../assets/css/pagination.css">
</head>

<main>
    <section>
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h3>Employees Salary Structure</h3>
            <a class="salary" href="/addsalary">+ Add Salary Structure</a>
        </div>
        <form method="GET" class="filter">
            <input type="text" name="name"    id="nameSearch" placeholder="Search by name"
                value="<?= isset($name) ? htmlspecialchars($name) : '' ?>" onchange="this.form.submit()">
            <select name="department" onchange="this.form.submit()">
                <option value="">All Departments</option>
                <?php
                $departments = ["HR", "Sales", "IT"]; 
                foreach ($departments as $dept) {
                    $selected = (isset($department) && $department == $dept) ? "selected" : "";
                    echo "<option value='$dept' $selected>$dept</option>";
                }
                ?>
            </select>
        </form>
        
        <?php if(isset($msg)) { echo '<p style="color:green;">'.$msg.'</p>'; } ?>


        <table border="1" cellpadding="10">
            <tr>
                <th>S.no</th>
                <th>Employee Id</th>
                <th>Employee Name</th>
                <th>Department</th>
                <th>Basic Salary</th>
                <th>HRA</th>
                <th>Deductions</th>
                <th>Action</th>
            </tr>
            <?php if(count($salaries) > 0) { ?>
                <?php foreach($salaries as $index => $row) { ?>
                <tr>
                    <td><?= ($page - 1) * 10 + $index + 1 ?></td>
                    <td><?= $row['emp_id'] ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['department']) ?></td>
                    <td><?= $row['basic_salary'] ?></td>
                    <td><?= $row['hra'] ?></td>
                    <td><?= $row['deductions'] ?></td>
                    <td><a href="/updatesalary?id=<?= $row['salary_id'] ?>">Update</a></td>
                </tr>
                <?php } ?>
            <?php } else { ?>
                <tr><td colspan="8" style="text-align: center;">No Records Found!</td></tr>
            <?php } ?>
        </table>
        <?php include '../app/views/layout/pagination.php' ?>
    </section>
</main>
