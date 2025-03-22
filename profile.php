<?php
require_once 'cfg.php';

if (!$user->isLogged()) {
    header('Location: login.php');
    exit();
}

// Pobranie motywu

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tytuł Strony</title>

    <?php include 'config/css.php'; ?>
    <?php include 'functions/themes.php'; ?>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>

    </script>
</head>

<body>
    <?php 
        $theme = $chat->getTheme();
        echo"<script> useTheme('".$theme['background']."');</script>";
    ?>

    <div class="user-profile shadow">
        <div class="banner ">
            <img id='banner' src="banner2.jpg" class="banner-img" alt="profile">

        </div>
        <div class="details">
            <img src="new.png" id='avatar' class="avatar" alt="profile">
            <span id='username' class="font username" id="username"><?= $user->getUsername();?> </span>
            <!-- <button class="save"></button> -->

            <!-- <input type="text" class="edit font username" value="Username"> -->
            <div class="line"></div>
            <div class="description font info">Joined
                <?php echo (new DateTime($user->getJoinDate()))->format('d.m.Y');       ?></div>
            <div class="description font">
                No bio yet
            </div>

        </div>
        <button class="button saveTheme" id="saveUsername">Save changes</button>

        <!-- <h3 class="ustawienia font ">Settings</h3> -->
        <div class="settings ">
            <e class="font ">Settings</e>
            <div class="setting selected" onclick="editUsername()">
                <i class="set-icon fa-solid fa-user fa-xl"></i>
                <div class="title font">Edit profile</div>
            </div>
            <div class="setting selected">
                <i class="set-icon fa-solid fa-palette fa-xl"></i>
                <div class="title font">Appearance</div>
            </div>
        </div>

    </div>
    <div id="result"></div>
    <?php
        require 'components/mobile_bar.php';
    ?>



    <script src="functions/js/xhr.js"></script>
    <script src="notification.js"></script>
    <script>
    function editUsername() {
        let element = document.getElementById("username")
        let input = document.createElement("input");
        let save = document.querySelector(".saveTheme");
        save.style.display = "block";
        input.type = "text";
        input.className = "edit font username";
        input.name = "username";
        input.value = element.innerText;

        element.replaceWith(input);
        input.focus();
    }
    document.getElementById("saveUsername").onclick = function() {
        abortEdit();
        let input = document.querySelector(".edit").value;
        let formData = new FormData();
        formData.append("username", input);
        quickXHR("xhr/edit_username.php", "POST", formData, "Successfully changed username");
    }

    function abortEdit() {
        setTimeout(() => {
            let input = document.querySelector(".edit");
            let element = document.createElement('div');
            element.className = "font username";

            element.id = "username";
            element.innerHTML = input.value;

            input.replaceWith(element);
            document.querySelector(".saveTheme").style.display = "none";
        }, 100);
    }
    </script>

    <?php include 'functions/websocket.php'; ?>

</body>

</html>