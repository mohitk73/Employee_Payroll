<head>
    <link rel="stylesheet" href="../assets/css/addemployee.css">
</head>
<main>
<form method="POST">
    <h3>Add New Employee</h3>
    <hr>
    <?php if(!empty($error)) {?>
        <div>
            <?php foreach ($error as $error) {?></div>
            <p style="color: red;margin-bottom:5px;"><?= $error ?></p>
            <?php }?>
             </div>
            <?php }?>
           

    <label>Name</label><br>
    <input type="text" name="name" pattern="[A-Za-z\s]{2,50}" title="Please enter Alphabets only" required><br><br>

    <label>Email</label><br>
    <input type="email" name="email" pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" required><br><br>

    <label>Password</label><br>
    <input type="password" name="password" required><br><br>

    <label>Role</label><br>
    <select name="role">
    <option value="0">Employee</option>
    <option value="1">Admin</option>
    <option value="2">HR</option>
    <option value="3">Manager</option>
</select><br><br>

    <label>Phone</label><br>
    <input type="text" name="phone" maxlength="10"  pattern="[0-9]{10}" required><br><br>

    <label>Position</label><br>
    <input type="text" name="position" required><br><br>

    <label>Department</label><br>
     <select name="department" required>
        <option value="">Select Department</option>
        <option value="IT">IT</option>
        <option value="HR">HR</option>
        <option value="Sales">Sales</option>
</select><br><br>
<label>Assign Manager</label><br>
<select name="manager_id">
     <option value="">No manager</option>
       <?php if (empty($managers)): ?>
    <?php else: ?>
        <?php foreach($managers as $m): ?>
            <option value="<?= $m['id'] ?>" <?= isset($employee['manager_id']) && $employee['manager_id'] == $m['id'] ? 'selected' : '' ?>>
                <?= $m['name'] ?>
            </option>
        <?php endforeach; ?>
    <?php endif; ?>
    </select><br><br>
    <label>Date of Joining</label><br>
    <input type="date" name="date_of_joining" required><br><br>

    <label>Address</label><br>
    <textarea name="address" rows="3" pattern="[A-Za-z0-9\s,.-]{5,150}" maxlength="150" required>
        <?= isset($employee['address']) ? htmlspecialchars($employee['address']) : '' ?>
    </textarea><br><br>

    <label>Status</label><br>
    <select name="status">
        <option value="1">Active</option>
        <option value="0">Inactive</option>
    </select><br><br>

    <button type="submit" name="add">Add Employee</button>
    <a class="back" href="/admin_employees">⬅ Back to Employee List</a>

</form>
<br>
</main>
