<?php
require('config.php');
if (!empty($_POST)) {

    $title = $_POST['title'];
    $description = $_POST['description'];
    $created_at = $_POST['created_at'];
    $id = $_GET['id'];

    if (!empty($_FILES['image']['name'])) {
        $targetFile = 'img/' . ($_FILES['image']['name']);
        $imageName = $_FILES['image']['name'];
        $imageType = pathinfo($targetFile, PATHINFO_EXTENSION);

        if ($imageType != 'png' && $imageType != 'jpg' && $imageType != 'jpeg') {
            echo "<script>alert('Image must be jpg, png or jpeg')</script>";
        } else {
            move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
            $pdo_statement = $pdo->prepare("UPDATE post SET id='$id',title='$title',description='$description',image='$imageName',created_at='$created_at' WHERE id='$id'");
            $result = $pdo_statement->execute();
        }
    } else {
        $pdo_statement = $pdo->prepare("UPDATE post SET id='$id',title='$title',description='$description',created_at='$created_at' WHERE id='$id'");
        $result = $pdo_statement->execute();
    }
    if ($result) {
        echo "<script>
    alert('Record is edited');
    window.location.href='index.php'</script>";
    }
}

$pdo_statement = $pdo->prepare("SELECT * FROM post WHERE id=" . $_GET['id']);
$pdo_statement->execute();
$result = $pdo_statement->fetchAll();
// print "<pre>";
// print_r($result);
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