<?php
require('config.php');
$pdo=new dataBase();
$pdo->deleteByID($_GET['id']);
?>