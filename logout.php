<?php
include 'conexao.php';
session_destroy();
header('Refresh: 0; url=login.php');
?>