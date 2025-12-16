
<head>
    <link rel="stylesheet" href="../assets/css/updatesalary.css">
</head>

<main>
    <section>
         <h3>Update Salary Structure</h3>
<?php if (!empty($errors)) : ?>
    <div style="color:red;">
        <?php foreach ($errors as $error) echo "<p>$error</p>"; ?>
    </div>
<?php endif; ?>
<form method="post">
            <label for="basic_salary">Basic Salary</label><br>
            <input type="number" name="basic_salary" value="<?= htmlspecialchars($salary['basic_salary']) ?>" required><br><br>

            <label for="hra">HRA (House Rent Allowance)</label><br>
            <input type="number" name="hra" value="<?= htmlspecialchars($salary['hra_allowances']) ?>" required><br><br>

            <label for="deductions">Fixed Deductions</label><br>
            <input type="number" name="deductions" value="<?= htmlspecialchars($salary['deduction']) ?>" required><br><br>
<a href="/salarystructure">⬅ Back</a>
            <button type="submit" name="update">Update Salary</button>
        </form>


        
    </section>
</main>
