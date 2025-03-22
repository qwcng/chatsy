<?php if(isset($_GET['id'])):?>
<div class="user-profile shadow">
    <i onclick="info()" class="fa-solid fa-arrow-left fa-xl"
        style="color: #ffffff; position:absolute; left:-20px; margin:10px auto;"></i>

    <div class="banner ">
        <img src="banner2.jpg" class="banner-img" alt="profile">

    </div>
    <div class="details">
        <img src="new.png" class="avatar" alt="profile">
        <e class="font username" id="username"><?php echo $chat->getSenderUsername($_GET['id']);?></e>
        <!-- <button class="save"></button> -->

        <!-- <input type="text" class="edit font username" value="Username"> -->
        <div class="line"></div>
        <div class="description font info">Joined 25.02.2025</div>
        <div class="description font">
            No bio yet
        </div>
    </div>
    <!-- <h3 class="ustawienia font ">Settings</h3> -->
    <div class="settings ">
        <e class="font">Settings</e>
        <div class="setting shadow" onclick="editUsername()">
            <i class="set-icon fa-solid fa-user fa-xl"></i>
            <div class="title font">Nicki</div>
        </div>
        <div class="setting shadow theme" onclick='themes();'>
            <i class="set-icon fa-solid fa-palette fa-xl"></i>
            <div class="title font">Motywy</div>
        </div>
        <span class="font themeName"></span>
        <form method="POST" id="theme">
            <input id='hiddenTheme' type="hidden" name="theme" value="1">
            <button type="submit" class="saveTheme button">Zapisz</button>
        </form>

    </div>

</div>
<div class="chat-app hide">
    <div class="header">
        <i onclick="back()" class="fa-solid fa-arrow-left fa-xl" style="color: #ffffff; margin: auto 10px;"></i>
        <img class="chat-pfp" src="pfp.png" alt="Chat Avatar">
        <i onclick="info()" class="fa-solid fa-gear fa-xl"
            style="color: #ffffff; margin: 25px 10px; position: absolute; right: 0;"></i>

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
        <?php endforeach; 
            
            ?>
        <!-- <div class="outcoming ">
                    <div class="message-data ">sIEMA <img src="banner2.jpg" alt=""> </div>
                    </div> -->


    </div>

    <div class="inputs" onsubmit="">
        <div><i class="fa-solid fa-image fa-xl" style="color: #ffffff;"></i></div>
        <textarea class="input-message" autocomplete="off" name="chat" onkeydown="clickPress(event)"
            oninput="height(this)" placeholder="Write a message"></textarea>
        <button onclick="sendMessage()" class="submit"><i class="fa-solid fa-paper-plane fa-xl"
                style="color: #FFFFFF;"></i></button>
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
        <a href="?id=<?php echo $friend['id']?>" class="friend-scroll">
            <img src='pfp.png' class=' avatar-scroll' alt='Friend Avatar'>
            <b class="font"><?php echo $chat->getSenderUsername($friend['id']) ?> </b>
        </a>
        <!-- </div> -->
        <?php endforeach;?>


    </div>
    <div class='friends'>

        <a style='text-decoration:none; margin: auto 0;' onclick="addFriend();" class=" setting  selected ">
            <i class="fa-solid fa-user-plus fa-xl" style="color: #ffffff;"></i>
            <div class='nick r font '>Dodaj znajomego</div>
        </a>

        <form id="addFriendm" method="post" class="form toast">
            <h2 class="font">Dodaj znajomego</h2>
            <i class="fa-solid fa-xmark fa-xl" style="color:rgb(255, 28, 28); position:absolute; right:0; margin:5px;"
                onclick="addFriend();"></i>
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
<?php
 require 'components/mobile_bar.php';
?>

<?php endif;?>