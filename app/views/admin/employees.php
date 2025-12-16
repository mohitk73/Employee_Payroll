<head>
    <link rel="stylesheet" href="../assets/css/employees.css">
    <link rel="stylesheet" href="../assets/css/pagination.css">
</head>

<main>
    <section>
        <h2>Employees List</h2>
        <a class="add" href="/addemployee">+ Add New Employee</a>
        <a class="add" href="/addsalary">+ Add Salary Structure</a>
        <a class="backdashboard" href="/admin_dashboard">Back to Dashboard</a>
        <br><br>
        <form method="GET" class="filter">
             <input type="hidden" name="route" value="admin_employees">
            <input type="text" name="name" placeholder="Search by name"
                   value="<?= htmlspecialchars($filters['name'] ?? '') ?>" onchange="this.form.submit()">

            <select name="department" onchange="this.form.submit()">
                <option value="">All Departments</option>
                <?php
                $departments = ["HR", "Sales", "IT"];
                foreach ($departments as $dept) {
                    $selected = ($filters['department'] ?? '') == $dept ? 'selected' : '';
                    echo "<option value='$dept' $selected>$dept</option>";
                }
                ?>
            </select>

            <select name="status" onchange="this.form.submit()">
                <option value="">All Status</option>
                <option value="1" <?= ($filters['status'] ?? '') === "1" ? "selected" : "" ?>>Active</option>
                <option value="0" <?= ($filters['status'] ?? '') === "0" ? "selected" : "" ?>>Inactive</option>
            </select>
        </form>

        <table border="1" cellpadding="8" cellspacing="0">
            <tr>
                <th>S.no</th>
                <th>Emp_Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Phone</th>
                <th>Position</th>
                <th>Department</th>
                <th>Manager_Id</th>
                <th>Date of Joining</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>

            <?php if (!empty($employees)) : 
                $sn = ($page - 1) * 5 + 1; 
                foreach ($employees as $row) : ?>
                    <tr>
                        <td><?= $sn++ ?></td>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= $row['email'] ?></td>
                        <td><?= $roles[$row['role']] ?? 'Unknown' ?></td>
                        <td><?= $row['phone'] ?></td>
                        <td><?= $row['position'] ?></td>
                        <td><?= $row['department'] ?></td>
                        <td><?= $row['manager_id'] ?></td>
                        <td><?= $row['date_of_joining'] ?></td>
                        <td>
                            <span class="status-badge <?= $row['status'] == 1 ? 'active' : 'inactive' ?>">
                                <?= $row['status'] == 1 ? 'Active' : 'Inactive' ?>
                            </span>
                        </td>
                        <td>
                            <a href="/editemployee?id=<?= $row['id'] ?>">Edit</a>
                            <a class="delete" href="/deleteemployee?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="13" style="text-align:center;">No Record Found!</td>
                </tr>
            <?php endif; ?>
        </table>
        <div class="pagination">
            <nav>
                <ul>
                    <?php if ($page > 1) : ?>
                        <li><a href="/admin_employees?page=<?= $page - 1 ?>">Previous</a></li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                        <li class="<?= ($i == $page) ? 'active' : '' ?>">
                            <a href="/admin_employees?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($page < $totalPages) : ?>
                        <li><a href="/admin_employees?page=<?= $page + 1 ?>">Next</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </section>
</main>