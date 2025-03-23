<?php

use React\Dns\Query\TimeoutExecutor;

require '../cfg.php';
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['status'])){
    echo 'success';
    $user->logout();
    
   
    
}