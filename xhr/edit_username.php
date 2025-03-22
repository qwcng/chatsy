<?php
require '../cfg.php';
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = $_POST['username'];
    $username = $_POST['username'];
    $user->setUsername($username);
    echo 'success';
}