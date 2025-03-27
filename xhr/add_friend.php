<?php
session_start();
require '../User.php';
$user = new User();
$chat= new Chat();
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'])) {
        $username = $_POST['username'];
        $userId = $user->getUserId();
        
        if ($chat->addFriend($userId, $username)) {
            echo 'success';  
        } else {
            echo 'error';
        }
    }
    ?>