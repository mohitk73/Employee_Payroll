<?php
use App\Helpers\Session;
Session::start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/login.css" >
</head>
<body>
    <section>
        
    <form method="POST" action="/auth">
        <h2>Sign In</h2>
        <?php if (Session::has('error')) { ?>
                <p style="color: red; margin-bottom: 5px;">
                    <?php 
                    echo Session::get('error');
                    Session::remove('error');
                    ?>
                </p>
            <?php } ?>
    <label for="email">Email</label><br>
    <input type="email" name="email"   pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" placeholder="Email"><br><br>
    <label for="password">Password</label><br>
    <input type="password" name="password" placeholder="Password"><br><br>
    <button type="submit"  name="login">Login</button><br>
</form>
</section>
</body>
</html>