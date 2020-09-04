<?php
require('config.php');
if (!empty($_POST)) {

    $targetFile = 'img/' . ($_FILES['image']['name']);
    $imageType = pathinfo($targetFile, PATHINFO_EXTENSION);

    if ($imageType != 'png' && $imageType != 'jpg' && $imageType != 'jpeg') {
        echo "<script>alert('Image must be jpg, png or jpeg')</script>";
    } else {
        move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
        print_r($_POST['created_at']);
        if ($_POST['created_at']) {
            $sql = "INSERT INTO post(title,description,image,created_at) VALUES(:title,:description,:image,:created_at)";
            $pdo_statement = $pdo->prepare($sql);
            $result = $pdo_statement->execute(
                array(':title' => $_POST['title'], ':description' => $_POST['description'], ':image' => $_FILES['image']['name'], ':created_at' => $_POST['created_at']));
        } else {
            $sql = "INSERT INTO post(title,description,image) VALUES(:title,:description,:image)";
            $pdo_statement = $pdo->prepare($sql);
            $result = $pdo_statement->execute(
                array(':title' => $_POST['title'], ':description' => $_POST['description'], ':image' => $_FILES['image']['name']));
        }
    }


    if ($result) {
        echo "<script>alert('record is added');
       window.location.href='index.php';</script>";
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