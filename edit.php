<?php
require('crud.php');
$pdo = new dataBase();
$pdo->edit($_POST,$_FILES);

$result = $pdo->getDataByID($_GET['id']);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Edit Record</title>

</head>

<body>
<div class='card'>
    <div class='card-body'>
        <h1>Edit record</h1>
        <form action="" method='post' enctype='multipart/form-data'>
            <div class='form-group'>
                <label for="title">Title</label>
                <input type="text" class='form-control' name='title' value='<?php echo $result[0]['title'] ?>'
                       required>
            </div>
            <div class='form-group'>
                <label for="description">Description</label>
                <textarea class='form-control' name='description'
                          required><?php echo $result[0]['description'] ?></textarea>
            </div>
            <div class='form-group'>
                <label for="image">Image</label><br>
                <img src="img/<?php echo $result[0]['image'] ?>" width='100' height='auto' alt="blar blar"><br><br>
                <input type="file" name='image' value=''>
            </div>
            <div class='form-group'>
                <label for="created_at">Date</label>
                <input type="date" class='form-control' name='created_at'
                       value='<?php echo date('Y-m-d', strtotime($result[0]['created_at'])); ?>'>
            </div>
            <div class='form-group'>
                <input type="submit" class=' btn btn-primary' value='Update'>
                <a class='btn btn-warning' href="index.php">Back</a>
            </div>
        </form>
    </div>
</div>
</body>

</html>