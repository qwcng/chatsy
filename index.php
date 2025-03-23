<?php
require_once 'cfg.php';

if(!$user->isLogged()){
    header('Location: login.php');

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Chat App</title>
    <?php include 'config/css.php';?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');

    .chat-app:has(.hide):not(.user-profile) {
        display: none;



    }

    .user-profile {
        position: relative;
        display: none;

        transition: 0.5s;

    }

    .chat-app:has(.hide) .user-profile {
        display: block;
        height: 100%;
    }
    </style>
    <?php
        include 'functions/themes.php';
    ?>


</head>

<body>

    <?php 
    $theme = $chat->getTheme();
    echo"<script> useTheme('".$theme['background']."');</script>";
    ?>
    <?php
        include 'functions/header.php';
    ?>
    <?php
        include 'functions/chat.php'
    ?>
    <div id="result"></div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="notification.js"></script>
    <script src="functions/js/xhr.js"></script>
    <script>
    function height(element) {
        let input = document.querySelector('.inputs');
        element.style.height = 'auto';
        input.style.height = 'auto';
        element.style.height = element.scrollHeight + 'px';
        input.style.height = element.scrollHeight + 'px';

    }


    function info() {
        let profile = document.querySelector('.user-profile');
        let chat = document.querySelector('.chat-app');
        if (profile.style.display == "none") {

            profile.style.display = "flex";

            chat.style.display = "none";
        } else {
            profile.style.display = "none";
            chat.style.display = "block";
        }
    }






    function pop() {
        const audio = new Audio('pop.ogg');
        audio.play().catch((error) => {
            console.error("Wystąpił błąd podczas odtwarzania dźwięku:", error);
        });

    }

    function addFriend() {
        console.log("123");
        let toast = document.getElementById("addFriend");
        if (toast.style.display == "none") {
            toast.style.display = "flex";
        } else {
            toast.style.display = "none";
        }
        // toast.style.display = "flex"
    }
    if (document.getElementById("addFriend")) {
        document.getElementById("addFriend").onsubmit = (e) => {
            e.preventDefault();

            const form = e.target;
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "xhr/add_friend.php", true); // Zmiana na oddzielny plik!

            xhr.onload = () => {
                console.log(xhr.responseText);
                if (xhr.status === 200) {
                    if (xhr.responseText === 'success') {
                        notification("Sukces: Dodano pomyślnie znajomego");
                    } else {
                        notification("Błąd: " + xhr.responseText);
                    }
                }
            };

            const formData = new FormData(form);
            xhr.send(formData);
            console.log(formData);
        };
    }
    if (document.getElementById("accept")) {
        document.getElementById("accept").onclick = (e) => {
            e.preventDefault();
            const form = e.target.closest('form');
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "xhr/accept_friend.php", true);
            xhr.onload = () => {
                if (xhr.status === 200) {
                    if (xhr.responseText === 'success') {
                        notification("Sukces: Zaakceptowano zaproszenie");
                        setTimeout(() => {
                            $("#friendsList").load("friends.php");
                        }, 100);

                    } else {
                        notification("Błąd: " + xhr.responseText);
                        console.log(xhr.responseText);
                    }
                }
            };
            const formData = new FormData(form);
            xhr.send(formData);
            console.log(formData);
        }
    }
    </script>
    <script>
    function searchFriends(element) {
        let input = element.value;
        let friends = document.querySelectorAll('.friend');
        let sum = 0;
        console.log(friends.length);
        friends.forEach(friend => {

            let name = friend.querySelector('.nick').innerText;
            if (name.toLowerCase().includes(input.toLowerCase())) {
                friend.style.display = "flex";
                setTimeout(() => {
                    friend.style.opacity = "1";
                    friend.style.width = "80%";
                }, 50);
            } else {
                friend.style.opacity = "0";
                setTimeout(() => {
                    friend.style.display = "none";
                    friend.style.width = "70%";
                }, 100);

                sum += 1;
            }


        })
        console.log(sum);
        if (friends.length == sum) {
            document.getElementById('resultM').innerHTML =
                "<span class='font'>Nie znaleziono znajomych</span>";
        } else {
            document.getElementById('resultM').innerHTML = "";
        }

    }
    </script>
    <?php
        include 'functions/websocket.php';
    ?>


</body>

</html>