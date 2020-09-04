<?php
require 'config.php';
$pdo=new dataBase();
$pdo->register($_POST);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>

<body>
<div class='card'>
    <div class='card-body'>
        <h1>Register</h1>
        <form action="register.php" method='post'>
            <div class='form-group'>
                <label for="username">Name</label>
                <input type="text" class='form-control' name='username' value='' required>
            </div>
            <div class='form-group'>
                <label for="email">email</label>
                <input type="email" class='form-control' name='email' value='' required>
            </div>
            <div class='form-group'>
                <label for="password">Password</label>
                <input type="password" class='form-control' name='password' value='' required>
            </div>
            <div class='form-group'>
                <input type="submit" class=' btn btn-primary' value='Register'>
                <a href="login.php">login</a>
            </div>
        </form>
    </div>
</div>
</body>

</html>