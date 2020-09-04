<?php
require('config.php');
$pdo=new dataBase();
$pdo->add($_POST,$_FILES);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <title>New Record</title>
</head>

<body>
<div class='card'>
    <div class='card-body'>
        <h1>New record</h1>
        <form action="add.php" method='post' enctype='multipart/form-data'>
            <div class='form-group'>
                <label for="title">Title</label>
                <input type="text" class='form-control' name='title' value='' required>
            </div>
            <div class='form-group'>
                <label for="description">Description</label>
                <textarea class='form-control' name='description' required></textarea>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" class='form-control' name='image'></div>
            <div class='form-group'>
                <label for="created_at">Date</label>
                <input type="date" class='form-control' name='created_at' value=''>
            </div>
            <div class='form-group'>
                <input type="submit" class=' btn btn-primary' value='ADD'>
                <a class='btn btn-warning' href="index.php">Back</a>
            </div>
        </form>
    </div>
</div>
</body>

</html>