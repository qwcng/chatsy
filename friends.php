<?php
require_once 'cfg.php';
$friends = $user->getFriends();
                foreach($friends as $friend):?>
                    <div class='friend selected'>
                        <a href='?id=<?php echo $friend['id'] ?>' style='text-decoration:none;'>
                            <div class='avatar'><img src='pfp.png' alt='Friend's Avatar'></div>
                            <div class='nick r font'><?php echo $chat->getSenderUsername($friend['id'])?></div>
                            <div class='message-s'><?php echo $chat->lastSentMessage($friend['id']); ?></div>
                        </a>
                    </div>
                <?php endforeach;?>
