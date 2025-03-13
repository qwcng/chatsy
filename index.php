<?php
session_start();
require 'User.php';
$user= new User();
$chat =new Chat();

if(!$user->isLogged()){
    header('Location: login.php');

}




// Fetch previous messages for this chat (user-to-user messaging)

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Chat App</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="notification.css">
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="components.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');
    </style>
</head>
<body>
    <div class="main ">
        <div class="profile ">
            <img class="pfp" src="pfp.png" alt="Profile Picture">
            
            <p class="username font " onclick="" ><?php echo $user->getUsername();?></p>
            <p></p>
        </div>
        <div class="friends">
            <div class='setting  selected ' >
                <a href='index.php' style='text-decoration:none; margin: auto 0;'> 
                    <div class='avatar'><i class="fa-solid fa-house fa-2xl" style="color:white"></i></div>
                    <div class='nick r font' >Strona główna</div>
                </a>
            </div>
            <div class='setting  selected ' >
                <a style='text-decoration:none; margin: auto 0;' onclick="addFriend();"> 
                    <div class='avatar'><i class="fa-solid fa-user-plus fa-2xl" style="color: #ffffff;"></i></div>
                    <div class='nick r font' >Dodaj znajomego</div>
                </a>
            </div>
            
            <form id="addFriend" method="post" class="form toast">
                <h2 class="font">Dodaj znajomego</h2>
                <i class="fa-solid fa-xmark fa-xl" style="color:rgb(255, 28, 28); position:absolute; right:0; margin:5px;" onclick="addFriend();"></i>></i>
                <input name="username" type="text" class="input" placeholder="nazwa użytkownika ">
                <button type="submit" class="button font">Dodaj</button>
            </form>
            
            <div class="search">
                <form action="post">
                    <i class="fa-solid fa-magnifying-glass fa-xl"></i>
                    <input type="text" class="search_input" placeholder="Search for friends">
                    
                </form>
                
            </div>
            <?php $friends = $user->getFriends();
            
            
            foreach($friends as $friend):?>
                <div class='friend selected'>
                                <a href='?id=<?php echo $friend['id'] ?>' style='text-decoration:none;'>
                                    <div class='avatar'><img src='pfp.png' alt='Friend's Avatar'></div>
                                    <div class='nick r font'><?php echo $chat->getSenderUsername($friend['id'])?></div>
                                    <div class='message-s'>Msg</div>
                                </a>
                </div>
            <?php endforeach;?>
            <h3 class="font">Przychodzące zaproszenia</h3>
            <?php $requests = $user->getPendingFriends();
            foreach($requests as $request):?>
            <div class='friend '>
                <div class="">
                    <div class='avatar'><img src='pfp.png' alt='Friend's Avatar'></div>
                    <div class="nick font">Userer</div>
                    <div class="message-s">
                    <i class="fa-solid fa-check fa-2xl" style="color:rgb(4, 224, 158);"></i>      
                    <i class="fa-solid fa-xmark fa-2xl" style="color: #ff0000;"></i>
                </div>
                </div>
                     
                

                
                                
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php if(isset($_GET['id'])):?>
    <div class="chat-app">
        <div class="header">
            <i onclick="back()" class="fa-solid fa-arrow-left fa-xl" style="color: #ffffff; margin: auto 10px;"></i>
            <img class="chat-pfp" src="pfp.png" alt="Chat Avatar"> 
            <div class="nick font"> <?php echo $chat->getSenderUsername($_GET['id']);?> <p class="status">Online</p></div>
        </div>
        <div class="chat-box " id="chatBox">
            
            
        <?php 
        
        
        $messages = $chat->getMessages($user->getUserId(),$_GET['id']);
        foreach ($messages as $message): ?>
                <div class="<?php echo $message['sender_id'] == $user->getUserId() ? 'outcoming' : 'incoming'; ?>">
                    <div class="message-data"><?php echo htmlspecialchars($message['message']); ?></div>
                </div>
            <?php endforeach; ?>
            <!-- <div class="incoming">
                    <div class="message-data">sIEMA <div></div><img src="new.png" alt=""> </div>
                </div> -->
        </div>
        <div class="inputs" onsubmit="">
            <textarea class="input-message" autocomplete="off" name="chat" onkeydown="clickPress(event)" oninput="height(this)" placeholder="Write a message" readonly onclick="this.removeAttribute('readonly');"> </textarea>   
            <button onclick="sendMessage()"  class="submit"><i class="fa-solid fa-paper-plane fa-2xl" style="color: #FFFFFF;"></i></button>
        </div>
    </div>
    
    <?php else:?>
    <div class="mobile  shadow">
        
        <div class="  mobile-header">
            <img src='new.png' lazy='load' class=' avatar' alt='Friend Avatar'>
            <h2 class="font "><?php echo $user->getUsername()?></h2>
        </div>
        
        <div class="friends-scroll  ">
            <?php foreach($friends as $friend):?>

            <div class="friend-scroll ">
                <a href="?id=<?php echo $friend['id']?>">
                    <img src='pfp.png'class=' avatar-scroll' alt='Friend Avatar'>
                    <b class="font"><?php echo $chat->getSenderUsername($friend['id']) ?> </b>
                </a>
            </div>
            <?php endforeach;?>

            
        </div>
        <div class='friends'>
            <div class="search">
                <form action="#">
                    <i class="fa-solid fa-magnifying-glass fa-xl"></i>
                    <input type="text" class="search_input" placeholder="Wyszukaj znajomych">
                </form>
            </div>
            <?php 
            $friends = $user->getFriends();
            foreach($friends as $friend): ?>
            
                <a href='?id=<?php echo $friend['id']; ?>' class='friend shadow' style='text-decoration:none;'>
                    <div class='avatar'><img src='pfp.png' lazy='load' alt='Friend Avatar'></div>
                    <div class='nick font r'><?php echo $chat->getSenderUsername($friend['id'])?></div>
                    <div class='message-s '>Msg</div>
                </a>
            
            <?php endforeach; ?>

    

        </div>
    </div>
    <div class="mobile-bar ">
        <a href='index.php' class="item">
            <i class="fa-solid fa-user-group fa-2xl" style="color:white;"></i>
        </a>
        <a href=''class="item">
            <i class="fa-solid fa-plus fa-2xl" style="color:white;"></i>
        </a>
        <a href='profile.html' class="item">
            <img src='new.png'class=' avatar-bar' alt='Friend Avatar'>
        </a>
    </div>

    <?php endif;?>
    <div id="result"></div>
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 <script src="notification.js"></script>
 
<script>
function addFriend(){
    
}
 document.getElementById("addFriend").onsubmit = (e) => {
    e.preventDefault();
    
    const form = e.target;
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "add_friend.php", true);  // Zmiana na oddzielny plik!

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
};
    </script>
    <script>
        <?php if(isset($_GET['id'])):?>
const conn = new WebSocket('ws://192.168.158.46:8080');

// Po nawiązaniu połączenia, wyślij user_id do serwera
conn.onopen = function() {
    console.log('Connected to WebSocket server');
    // Wysłanie user_id po połączeniu
    conn.send(JSON.stringify({ user_id: <?php echo $user->getUserId(); ?> }));
};

conn.onmessage = function(e) {
    const data = JSON.parse(e.data);
    const chatBox = document.getElementById('chatBox');
    const messageClass = data.sender_id == <?php echo $user->getUserId(); ?> ? 'outcoming' : 'incoming';
    chatBox.innerHTML += `<div class="${messageClass}"><div class="message-data">${data.message}</div></div>`;
    chatBox.scrollTop = chatBox.scrollHeight;
};

// Funkcja do wysyłania wiadomości
function sendMessage() {
    const message = document.querySelector('.input-message').value;
    if (message.trim() !== "") {
        const data = {
            message: message,
            sender_id: <?php echo $user->getUserId(); ?>,  // Zalogowany użytkownik
            receiver_id: <?php echo $_GET['id']; ?>  // Odbiorca z URL
        };

        // Wysłanie danych do serwera WebSocket
        conn.send(JSON.stringify(data));

        // Dodanie wiadomości do chat box (lokalne wyświetlanie)
        const chatBox = document.getElementById('chatBox');
        chatBox.innerHTML += `<div class="outcoming"><div class="message-data">${message}</div></div>`;
        chatBox.scrollTop = chatBox.scrollHeight;

        // Czyszczenie inputa
        document.querySelector('.input-message').value = '';
    }
}
    <?php endif;?>
        function clickPress(event) {
        if (event.key == "Enter" && !event.shiftKey) {
            event.preventDefault();
            sendMessage();
        }
        }
        function changeUsername(element){
            let input = document.createElement("input");
            input.type = "text";
            input.className = element.className;
            input.value = element.innerText;
            element.replaceWith(input);
            input.focus();
        }
        function back(){
            window.location.href = "index.php";
        }
    </script>
    
</body>
</html>
