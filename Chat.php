<?php

// class Chat extends User{
//     public $pdo;
//     function __construct(){
//         $this->pdo = $GLOBALS['pdo'];
//     }
//     function getMessages($id,$receiver_id){
//         $stmt = $pdo->prepare("SELECT * FROM messages WHERE (receiver_id = :user_id AND sender_id = :receiver_id) OR (receiver_id = :receiver_id AND sender_id = :user_id) ORDER BY sent_at ASC");
// $stmt->bindParam(':user_id', $user_id);
// $stmt->bindParam(':receiver_id', $receiver_id);
// $stmt->execute();
// $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
//     }
// }