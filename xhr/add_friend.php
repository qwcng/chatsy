<?php
session_start();
require '../User.php';
$user = new User();
$chat= new Chat();
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'])) {
        $username = $_POST['username'];
        // Sprawdzenie, czy użytkownik istnieje w bazie
        $userId = $user->getUserId();
        
        if ($chat->addFriend($userId, $username)) {
            echo 'success';  // Możesz tu zwrócić odpowiedź, żeby JavaScript wiedział, czy wszystko poszło ok
        } else {
            echo 'error';
        }
    }
    ?>