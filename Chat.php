<?php
class Chat extends User{
    private $id;
    public $pdo;
    public function __construct(){
        if($this->isLogged()){
            $this-> id = $_SESSION['login'];    
        }
        $this->pdo = DB::getPDO();
    }
    function getMessages($id,$receiver_id){
        $stmt = $this->pdo->prepare("SELECT * FROM messages WHERE (receiver_id = :user_id AND sender_id = :receiver_id) OR (receiver_id = :receiver_id AND sender_id = :user_id) ORDER BY sent_at ASC");
        $stmt->bindParam(':user_id', $id);
        $stmt->bindParam(':receiver_id', $receiver_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    function sendMessage($id,$receiver_id,$message){
        $stmt = $this->pdo->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (:sender_id, :receiver_id, :message)");
        $stmt->bindParam(':sender_id', $id);
        $stmt->bindParam(':receiver_id', $receiver_id);
        $stmt->bindParam(':message', $message);
        $stmt->execute();
    }
    function getSenderUsername($sender_id){
        
        $id= $this->getUserId();
        $query = "SELECT username FROM users WHERE id = :id LIMIT 1";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $sender_id, PDO::PARAM_INT);
        $stmt->execute();
            
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['username'];
            
    }

    function addFriend($id,$friend){
        $user = "SELECT id FROM users WHERE username = :username LIMIT 1";
        $execute = $this->pdo->prepare($user);
        $execute->bindParam(':username', $friend);
        $execute->execute();
        if($result = $execute->fetch(PDO::FETCH_ASSOC)){
            $friend_id = $result['id'];
        }
        
        $query = "INSERT INTO friends (user1, user2,status) VALUES (:user1,:friend,'pending')";
        $stmt = $this->pdo->prepare($query);
        $stmt ->bindParam(":user1",$id);
        $stmt-> bindParam(":friend",$friend_id);
        $stmt->execute();
        return true;

    }
    function lastSentMessage($sender_id){
        $id = $this->getUserId();
        $stmt = $this->pdo->prepare("SELECT * FROM messages WHERE (receiver_id = :user_id AND sender_id = :receiver_id) OR (receiver_id = :receiver_id AND sender_id = :user_id) ORDER BY sent_at DESC LIMIT 1");
        $stmt->bindParam(':user_id', $id);
        $stmt->bindParam(':receiver_id',$sender_id);    
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!empty($result)){
            return $result['message'];
        }
        else{
            return "<i>Brak wiadomości</i>";
        }
    
    }
    function isOnline($id){
        $query = "SELECT status FROM users WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result['status'] == 'online'){
            return true;
        }
        else{
            return false;
        }
    }
    function getTheme(){
        $query = "SELECT name,background,colors FROM users 
        JOIN themes ON users.theme = themes.id
        WHERE users.id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id',$this->id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    function getAllThemes(){
        $query = "SELECT * FROM themes ORDER BY id ASC";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    function addTheme($file,$name,$colors){
        $query = "INSERT INTO themes (name,background,colors) VALUES (:name,:background,:colors)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':name',$name);
        $stmt->bindParam(':background',$file);
        $stmt->bindParam(':colors',$colors);
        $stmt->execute();
        

    }
}