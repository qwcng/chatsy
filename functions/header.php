<div class="main ">
    <div class="profile ">
        <img class="pfp" src="pfp.png" alt="Profile Picture">

        <p class="username font " onclick=""><?php echo $user->getUsername();?></p>
        <p></p>
    </div>
    <div class="friends" id="friends">

        <div class="setting  selected">
            <a href='index.php' style='text-decoration:none; margin: auto 10px; '>
                <div class="avatar"><i class="fa-solid fa-house fa-2xl" style="color:white"></i></div>
                <div class='nick r font'>Strona główna</div>
            </a>
        </div>
        <div class="setting  selected ">
            <a style='text-decoration:none; margin: auto 10px;' onclick="addFriend();">
                <div class="avatar"><i class="fa-solid fa-user-plus fa-2xl" style="color: #ffffff;"></i></div>
                <div class='nick r font'>Dodaj znajomego</div>
            </a>
        </div>


        <form id="addFriend" method="post" class="form toast">
            <h2 class="font">Dodaj znajomego</h2>
            <i class="fa-solid fa-xmark fa-xl" style="color:rgb(255, 28, 28); position:absolute; right:0; margin:5px;"
                onclick="addFriend();"></i>
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
                <div class='avatar'><img src='pfp.png' alt='Friend' s Avatar'></div>
                <div class="nick font">Userer</div>
                <div class="message-s">
                    <form action="" method="POST" id="accept">
                        <input type="hidden" name="action" value="">
                        <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
                        <button type="submit" onclick="this.form.action.value='accept';"
                            style="background: none; border: none;">
                            <i class="fa-solid fa-check fa-2xl" style="color:rgb(4, 224, 158);"></i>
                        </button>
                        <button type="submit" onclick="this.form.action.value='reject';"
                            style="background: none; border: none;">
                            <i class="fa-solid fa-xmark fa-2xl" style="color: #ff0000;"></i>
                        </button>
                    </form>
                </div>
            </div>





        </div>
        <?php endforeach; ?>

    </div>
</div>