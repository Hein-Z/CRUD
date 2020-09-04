<?php
require 'config.php';
if (!empty($_POST)) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($username == '' || $email == '' || $password == '') {
        echo '<script>
        alert("Fill the form data");
        </script>';
    } else {
        $sql = 'SELECT COUNT(email) as num FROM users WHERE email=:email';
        $stml = $pdo->prepare($sql);
        $stml->bindValue(':email', $email);
        $stml->execute();
        $row = $stml->fetch(PDO::FETCH_ASSOC);
        if ($row['num'] > 0) {
            echo '<script>alert("This user already exists");</script>';
        } else {
            $passwordhash = password_hash($password, PASSWORD_BCRYPT);
            $sql = 'INSERT INTO users(name,email,password) VALUES (:name,:email,:password)';
            $stml = $pdo->prepare($sql);
            $stml->bindValue(':name', $username);
            $stml->bindValue(':email', $email);
            $stml->bindValue(':password', $passwordhash);
            $result = $stml->execute();
            if ($result) {
                echo 'Thank for your registration!' . '<a href="login.php">Login</a>';
            }
        }
    }
}
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