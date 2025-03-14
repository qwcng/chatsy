<?php
session_start();
require '../User.php';
$user = new User();
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['request_id'])) {
        $requestId = $_POST['request_id'];
        // Sprawdzenie, czy użytkownik istnieje w bazie
        $userId = $user->getUserId();
        
        if ($user->accepptRequest($requestId)) {
            echo 'success';  // Możesz tu zwrócić odpowiedź, żeby JavaScript wiedział, czy wszystko poszło ok
        } else {
            echo 'error';
        }
    }
?>