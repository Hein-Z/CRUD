<?php
define('MYSQL_USER', 'root');
define('MYSQL_PASSWORD', '');
define('MYSQL_HOST', 'localhost');
define('MYSQL_DATABASE', 'fwdclass');

class dataBase
{
    public static $pdo;

    public function __construct()
    {
        $pdoOptions = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        );
        self::$pdo = new PDO(
            'mysql:host=' . MYSQL_HOST . ';dbname=' . MYSQL_DATABASE,
            MYSQL_USER, MYSQL_PASSWORD,
            $pdoOptions
        );
        return self::$pdo;
    }

    public function add($add, $image)
    {
        if (!empty($add)) {

            $targetFile = 'img/' . ($image['image']['name']);
            $imageType = pathinfo($targetFile, PATHINFO_EXTENSION);

            if ($imageType != 'png' && $imageType != 'jpg' && $imageType != 'jpeg') {
                echo "<script>alert('Image must be jpg, png or jpeg')</script>";
            } else {
                move_uploaded_file($image['image']['tmp_name'], $targetFile);
                print_r($add['created_at']);
                if ($add['created_at']) {
                    $sql = "INSERT INTO post(title,description,image,created_at) VALUES(:title,:description,:image,:created_at)";
                    $pdo_statement = self::$pdo->prepare($sql);
                    $result = $pdo_statement->execute(
                        array(':title' => $add['title'], ':description' => $add['description'], ':image' => $image['image']['name'], ':created_at' => $add['created_at']));
                } else {
                    $sql = "INSERT INTO post(title,description,image) VALUES(:title,:description,:image)";
                    $pdo_statement = self::$pdo->prepare($sql);
                    $result = $pdo_statement->execute(
                        array(':title' => $add['title'], ':description' => $add['description'], ':image' => $image['image']['name']));
                }
            }
            if (isset($result)) {
                echo "<script>alert('record is added');window.location.href='index.php';</script>";
            }
        }
    }

    public function deleteByID($ID)
    {
        $pdo_statement = self::$pdo->prepare('DELETE FROM post WHERE id=:id');
        $pdo_statement->bindValue(':id', $ID);
        $pdo_statement->execute();
        header('Location:index.php');
    }

    public function edit($data, $image)
    {
        if (!empty($data)) {

            $title = $data['title'];
            $description = $data['description'];
            $created_at = $data['created_at'];
            $id = $_GET['id'];

            if (!empty($image['image']['name'])) {
                $targetFile = 'img/' . ($image['image']['name']);
                $imageName = $image['image']['name'];
                $imageType = pathinfo($targetFile, PATHINFO_EXTENSION);

                if ($imageType != 'png' && $imageType != 'jpg' && $imageType != 'jpeg') {
                    echo "<script>alert('Image must be jpg, png or jpeg')</script>";
                } else {
                    move_uploaded_file($image['image']['tmp_name'], $targetFile);
                    $pdo_statement = self::$pdo->prepare("UPDATE post SET id='$id',title='$title',description='$description',image='$imageName',created_at='$created_at' WHERE id='$id'");
                    $result = $pdo_statement->execute();
                }
            } else {
                $pdo_statement = self::$pdo->prepare("UPDATE post SET id='$id',title='$title',description='$description',created_at='$created_at' WHERE id='$id'");
                $result = $pdo_statement->execute();
            }
            if (isset($result)) {
                echo "<script>alert('Record is edited');window.location.href='index.php'</script>";
            }
        }
    }

    public function getData()
    {
        $pdo_statement = self::$pdo->prepare('SELECT * FROM post ORDER BY id DESC');
        $pdo_statement->execute();
        return $pdo_statement->fetchAll();
    }

    public function getDataByID($ID)
    {
        $pdo_statement = self::$pdo->prepare("SELECT * FROM post WHERE id=:id");
        $pdo_statement->bindValue(':id', $ID);
        $pdo_statement->execute();
        return $pdo_statement->fetchAll();
    }

    public function login($data)
    {

        if (!empty($data)) {
            $email = $data['email'];
            $password = $data['password'];
            $sql = 'SELECT * FROM users WHERE email=:email';

            $stml = self::$pdo->prepare($sql);
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
    }

    public function register($data)
    {
        if (!empty($data)) {
            $username = $data['username'];
            $email = $data['email'];
            $password = $data['password'];

            if ($username == '' || $email == '' || $password == '') {
                echo '<script>alert("Fill the form data");</script>';
            } else {
                $sql = 'SELECT COUNT(email) as num FROM users WHERE email=:email';
                $stml = self::$pdo->prepare($sql);
                $stml->bindValue(':email', $email);
                $stml->execute();
                $row = $stml->fetch(PDO::FETCH_ASSOC);
                if ($row['num'] > 0) {
                    echo '<script>alert("This user already exists");</script>';
                } else {
                    $passwordhash = password_hash($password, PASSWORD_BCRYPT);
                    $sql = 'INSERT INTO users(name,email,password) VALUES (:name,:email,:password)';
                    $stml = self::$pdo->prepare($sql);
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
    }

}

?>