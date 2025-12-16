<head>
   <link rel="stylesheet" href="../assets/css/addsalary.css" >
</head>
<main>
    <section>
       <form method="post" action="">

       <h3>Set Salary Structure</h3><br>
       <hr>
<?php if (!empty($error)) : ?>
    <div style="color:red;">
        <?php foreach ($error as $error) echo "<p>$error</p>"; ?>
    </div>
<?php endif; ?>
    <label>Employee:</label>
    <select name="employee_id" required>
        <option value="">Select Employee</option>
        <?php foreach ($employees as $employee): ?>
                    <option value="<?= $employee['id']; ?>"><?= $employee['name']; ?></option>
                <?php endforeach; ?>
    </select>
 
    <br><br>
    <label>Basic Salary:</label>
    <input type="number" name="basic_salary" pattern="^[0-9]+(\.[0-9]{1,2})?$" required>
    <br><br>

    <label>HRA (House Rent Allowance):</label>
    <input type="number" name="hra" pattern="^[0-9]+(\.[0-9]{1,2})?$" required>
    <br><br>

    <label>Fixed Deductions:</label>
    <input type="number" name="deductions" pattern="^[0-9]+(\.[0-9]{1,2})?$" required>
    <br><br>
    <div class="salary"><a href="/admin_employees" class="back"><- Back to Employees</a>
    <button type="submit" name="submit">Save Salary Structure</button>

</div>
</form>
    </section>
</main>