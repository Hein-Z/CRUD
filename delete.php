<?php
require('crud.php');
$pdo=new dataBase();
$pdo->deleteByID($_GET['id']);
?>