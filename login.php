<?php
require 'config.php';
if (!empty($_POST)) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = 'SELECT * FROM users WHERE email=:email';
    $stml = $pdo->prepare($sql);
    $stml->bindValue(':email', $email);
    $stml->execute();
    $user = $stml->fetch(PDO::FETCH_ASSOC);
    if (empty($user)) {
        echo "<script>alert('Incorrect credentials, Try again')</script>";
    } else {
        $validPassword = password_verify($password, $user['password']);
        if ($validPassword) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['logged_in'] = time();
            header('Location: index.php');
            exist();
        } else {
            echo "<script>alert('Incorrect credentials, Try again');</script>";
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
        <h1>Log In</h1>
        <form action="login.php" method='post'>
            <div class='form-group'>
                <label for="email">email</label>
                <input type="email" class='form-control' name=' email' value='' required>
            </div>
            <div class='form-group'>
                <label for="password">Password</label>
                <input type="password" class='form-control' name=' password' value='' required>
            </div>
            <div class='form-group'>
                <input type="submit" class=' btn btn-primary'>
                <a href="register.php">Register</a>
            </div>
        </form>
    </div>
</div>
</body>

</html>