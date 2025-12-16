

<head>
    <title>Edit Employee</title>
    <link rel="stylesheet" href="../assets/css/editemployee.css">
</head>
<main>
<section>
<h2>Edit Employee</h2>
<?php if(!empty($error)): ?>
    <div style="color:red;">
        <?php foreach($error as $e) echo "<p>$e</p>"; ?>
    </div>
<?php endif; ?>

<form action="/editemployee?id=<?= $employee['id'] ?>" method="POST">
    Name:<br>
    <input type="text" name="name" value="<?= htmlspecialchars($employee['name']) ?>" pattern="[A-Za-z\s]{2,50}" required><br><br>

    Email:<br>
    <input type="email" name="email" value="<?= $employee['email'] ?>" required><br><br>

    Phone:<br>
    <input type="text" name="phone" value="<?= $employee['phone'] ?>" pattern="[0-9]{10}" maxlength="10" required><br><br>

    Role:<br>
    <select name="role">
        <?php foreach($roles as $key => $roleName): ?>
            <option value="<?= $key ?>" <?= $employee['role'] == $key ? 'selected' : '' ?>><?= $roleName ?></option>
        <?php endforeach; ?>
    </select><br><br>

    Position:<br>
    <input type="text" name="position" value="<?= $employee['position']  ?>" required maxlength="100" pattern="[A-Za-z0-9 ]+"><br><br>

    Department:<br>
    <select name="department" required>
        <?php foreach(['IT','HR','Sales'] as $dept): ?>
            <option value="<?= $dept ?>" <?= $employee['department']==$dept?'selected':'' ?>><?= $dept ?></option>
        <?php endforeach; ?>
    </select><br><br>

    Manager:<br>
    <select name="manager_id">
        <option value="">No Manager</option>
        <?php foreach($managers as $m): ?>
            <option value="<?= $m['id'] ?>" <?= $employee['manager_id']==$m['id']?'selected':'' ?>><?= $m['name'] ?></option>
        <?php endforeach; ?>
    </select><br><br>

    Status:<br>
    <select name="status">
        <option value="1" <?= $employee['status']==1?'selected':'' ?>>Active</option>
        <option value="0" <?= $employee['status']==0?'selected':'' ?>>Inactive</option>
    </select><br><br>

    <button type="submit">Update Employee</button>
    <a href="/admin_employees">⬅ Back</a>
</form>
</section>
</main>
