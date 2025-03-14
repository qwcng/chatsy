<?php
require_once 'cfg.php';

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
        <div class="friends" id="friends">
            
            <div class="setting  selected">
                <a href='index.php' style='text-decoration:none; margin: auto 10px; '> 
                    <div class="avatar"><i class="fa-solid fa-house fa-2xl" style="color:white"></i></div>
                    <div class='nick r font' >Strona główna</div>
                </a> 
            </div>
            <div class="setting  selected ">
                <a style='text-decoration:none; margin: auto 10px;' onclick="addFriend();" > 
                    <div class="avatar"><i class="fa-solid fa-user-plus fa-2xl" style="color: #ffffff;"></i></div>
                    <div class='nick r font' >Dodaj znajomego</div>
                </a>
            </div>
            
            
            <form id="addFriend" method="post" class="form toast" >
                <h2 class="font">Dodaj znajomego</h2>
                <i class="fa-solid fa-xmark fa-xl" style="color:rgb(255, 28, 28); position:absolute; right:0; margin:5px;" onclick="addFriend();"></i>
                <input name="username" type="text" class="input" placeholder="nazwa użytkownika ">
                <button type="submit" class="button font">Dodaj</button>
            </form>
            
            <div class="search">
                <form action="post">
                    <i class="fa-solid fa-magnifying-glass fa-xl"></i>
                    <input type="text" class="search_input" placeholder="Search for friends">
                    
                </form>
                
            </div>
            <div id="friendsList" class="friends" style="width: 100%;">
                <?php 
                    include 'friends.php';
                ?>
            </div>
            
            <?php 
            // if($user->accepptRequest(4)){
            //     echo "wow";
            // }

            ?>
            <h3 class="font">Przychodzące zaproszenia</h3>
            <?php $requests = $user->getPendingFriends();
            foreach($requests as $request):?>
            <div class='friend '>
                <div class="">
                    <div class='avatar'><img src='pfp.png' alt='Friend's Avatar'></div>
                    <div class="nick font">Userer</div>
                    <div class="message-s">
                    <form action="" method="POST" id="accept">
                        <input type="hidden" name="action" value="">
                        <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
                        <button type="submit" onclick="this.form.action.value='accept';" style="background: none; border: none;">
                            <i class="fa-solid fa-check fa-2xl" style="color:rgb(4, 224, 158);"></i>
                        </button>
                        <button type="submit" onclick="this.form.action.value='reject';" style="background: none; border: none;">
                            <i class="fa-solid fa-xmark fa-2xl" style="color: #ff0000;"></i>
                        </button>
                    </form>
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
            <div class="nick font"> <?php echo $chat->getSenderUsername($_GET['id']);?>
                <?php if($chat->isOnline($_GET['id'])){
                    echo "<p class='status online'>online </p>";
                }else{
                    echo "<p class='status offline'>offline </p>";   
                }?>
    </div>
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

            <!-- <div class=" "> -->
                <a href="?id=<?php echo $friend['id']?>" class="friend-scrol">
                    <img src='pfp.png'class=' avatar-scroll' alt='Friend Avatar'>
                    <b class="font"><?php echo $chat->getSenderUsername($friend['id']) ?> </b>
                </a>
            <!-- </div> -->
            <?php endforeach;?>

            
        </div>
        <div class='friends'>

            <a style='text-decoration:none; margin: auto 0;' onclick="addFriend();" class=" setting  selected "> 
                <i class="fa-solid fa-user-plus fa-xl" style="color: #ffffff;"></i>
                <div class='nick r font ' >Dodaj znajomego</div>
            </a>

        <form id="addFriendm" method="post" class="form toast" >
                <h2 class="font">Dodaj znajomego</h2>
                <i class="fa-solid fa-xmark fa-xl" style="color:rgb(255, 28, 28); position:absolute; right:0; margin:5px;" onclick="addFriend();"></i>
                <input name="username" type="text" class="input" placeholder="nazwa użytkownika ">
                <button type="submit" class="button font">Dodaj</button>
            </form>
            <div class="search selected">
                <form action="#">
                    <i class="fa-solid fa-magnifying-glass fa-xl"></i>
                    <input type="text" class="search_input" placeholder="Wyszukaj znajomych">
                </form>
            </div>
            
            <div id="friendsList" class="friends" style="width: 100%;">
                <?php 
                    include 'friends.php';
                ?>
            </div>


    

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
function pop() {
        const audio = new Audio('pop.ogg');
        audio.play().catch((error) => {
            console.error("Wystąpił błąd podczas odtwarzania dźwięku:", error);
        });
    
}
function addFriend(){
    console.log("123");
    let toast = document.getElementById("addFriend");
    if(toast.style.display == "none"){
        toast.style.display = "flex";
    }
    else{
        toast.style.display = "none";
    }
    // toast.style.display = "flex"
}
if(document.getElementById("addFriend")){
 document.getElementById("addFriend").onsubmit = (e) => {
    e.preventDefault();
    
    const form = e.target;
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "xhr/add_friend.php", true);  // Zmiana na oddzielny plik!

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
if(document.getElementById("accept")){
    document.getElementById("accept").onclick = (e) =>{
        e.preventDefault();
        const form = e.target.closest('form');
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "xhr/accept_friend.php", true);
        xhr.onload = ()=>{
            if(xhr.status === 200){
                if(xhr.responseText === 'success'){
                    notification("Sukces: Zaakceptowano zaproszenie");
                    setTimeout(()=>{
                        $("#friendsList").load("friends.php");
                    }, 100);
                    
                }else{
                    notification("Błąd: " + xhr.responseText);
                    console.log(xhr.responseText);
                }
            }
        };
        const formData = new FormData(form);
        xhr.send(formData);
        console.log(formData);
    }}
        </script>
    <script>
        
        const chatBox = document.getElementById('chatBox');
        chatBox.scrollTop = chatBox.scrollHeight;
        
        <?php if(isset($_GET['id'])):?>
const conn = new WebSocket('ws://192.168.73.34:8080');

// Po nawiązaniu połączenia, wyślij user_id do serwera
conn.onopen = function() {
    console.log('Connected to WebSocket server');
    conn.send(JSON.stringify({ user_id: <?php echo $user->getUserId(); ?> }));
};

conn.onmessage = function(e) {
    const data = JSON.parse(e.data);
    const chatBox = document.getElementById('chatBox');
    pop();
    const messageClass = data.sender_id == <?php echo $user->getUserId(); ?> ? 'outcoming' : 'incoming';
    chatBox.innerHTML += `<div class="${messageClass}"><div class="message-data">${data.message}</div></div>`;
    chatBox.scrollTop = chatBox.scrollHeight;
    setTimeout(()=>{
                        $("#friendsList").load("friends.php");
                    }, 100);};

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
        setTimeout(()=>{
                        $("#friendsList").load("friends.php");
                    }, 100);
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
