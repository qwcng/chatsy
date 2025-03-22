<?php
session_start();
require 'User.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Ubuntu+Sans:ital,wght@0,100..800;1,100..800&display=swap');

    body {
        margin: 0;
        height: 100vh;
        background: url('themes/bg.jpg');
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;

        display: flex;
        justify-content: center;
        align-items: center;

    }

    .font {
        color: white;
        font-family: "Poppins", sans-serif;
        font-weight: 500;
    }

    .form h4,
    h2 {
        margin-bottom: 10px;
    }

    .header {
        font-weight: 600;
    }

    .form {
        padding: 15px;
        border-radius: 10px;
        backdrop-filter: brightness(93%);
    }

    .border {
        border: 1px solid black;
    }

    .header {
        margin: 0 auto;
    }

    .form {
        display: flex;
        flex-direction: column;
        width: 80%;
        width: 300px;
        max-width: 300px;
        height: 390px;
        border: 2px solid #d8d6d6;

    }

    .input {
        padding: 5px;
        border-radius: 10px;
        border: 1px solid white;
        background: none;
        backdrop-filter: brightness(73%);
        color: white;
        height: 32px;
    }

    .button {
        height: 40px;
        border-radius: 15px;
        border: none;
        color: black;
        font-weight: 500;
        background-color: rgb(240, 240, 240);
        margin-top: 30px;
        transition: 0.6s;
        cursor: pointer
    }

    .button:hover {
        filter: brightness(70%);
    }

    .link {
        padding: 5px;
        color: white;
        font-family: "Poppins", sans-serif;
        font-weight: 200;
        text-decoration: none;
        font-size: 0.9rem;
    }
    </style>
</head>

<body class="border">
    <form method="post" id="register">
        <div class="form">
            <h2 class="font header">Zarejestruj się</h2>
            <h4 class="font">Nazwa użytkownika</h4>
            <input type="text" class="input font" name='username' placeholder="Nazwa użytkownika">
            <h4 class="font">Adres e-mail</h4>
            <input type="text" class="input font" name='email' placeholder="Adres e-mail">
            <h4 class="font">Hasło</h4>
            <input type="password" class="input font" name='password' placeholder="Hasło">
            <a href="" class="link">Zapomniałeś hasła?</a>
            <a href="login.php" class="link">Masz konto</a>
            <button type="submit" class="button font"> Zarejestruj się</button>

        </div>
    </form>
    <?php
        if($_SERVER['REQUEST_METHOD'] === "POST"){
            if (!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['username'])) {
                $user = new User();
                $user->register($_POST['email'],$_POST['password'],$_POST['username']);

                
            } else {
                echo "Proszę wypełnić wszystkie pola!";
            }
        }
   ?>
    <script>
    // document.getElementById("register").addEventListener("submit", function(e) {
    //     e.preventDefault();
    //     });
    </script>
</body>

</html>