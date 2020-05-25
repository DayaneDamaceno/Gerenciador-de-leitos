<?php

$username  ='root';
$password = '';


try{
    $conn = new PDO('mysql:host=localhost;dbname=db_hospital;charset=utf8', $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>