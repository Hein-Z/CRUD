<?php
session_start();
require('config.php');
$pdo = new dataBase();

if (empty($_SESSION['user_id']) || empty($_SESSION['logged_in'])) {
    echo "<script>alert('Please Login to continue');window.location.href='login.php';</script>";
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
<?php
$result=$pdo->getData();
?>

<h1 class='text-center'>__Posts Management__</h1>

<a class='btn btn-outline-dark' href='add.php'>Created New</a>
<a class='btn btn-dark float-right' href='logout.php'>Log Out</a>
<table class="table table-striped table-dark mt-2">
    <thead>
    <tr>
        <th scope="col">Title</th>
        <th scope="col">Description</th>
        <th scope="col">Created at</th>
        <th scope="col">Action</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if ($result) :
        foreach ($result as $value) :

            ?>
            <tr>
                <td><?php echo $value['title']; ?></td>
                <td><?php echo $value['description']; ?></td>
                <td><?php echo date('d-m-Y', strtotime($value['created_at'])); ?> </td>
                <td><a href="edit.php?id=<?php echo $value['id'] ?>">Edit Post</a><br>
                    <a href="delete.php?id=<?php echo $value['id'] ?>">Delete Post</a></td>

            </tr>
            <?php
        endforeach;
    endif;
    ?>
    </tbody>
</table>
</body>

</html>
