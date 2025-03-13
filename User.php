<?php
require_once 'db.php';
class User{
    private $username;
    private $password;
    private $email;
    private $id;
    public $pdo;

    
    function __construct(){
        if($this->isLogged()){
            $this-> id = $_SESSION['login'];    
        }
        $this->pdo = DB::getPDO();
        
        
    }
    function isLogged(){
        if(isset($_SESSION['login'])){
            return true;
        }
    }
    function getUserId(){
        if($this->isLogged()){
            
            return $_SESSION['login'];
            
        
        }
    }
    function getUsername(){
        if($this->isLogged()){
        $id= $this->getUserId();
        $query = "SELECT username FROM users WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['username'];
        }

    }
    function setUsername($username){
        if($this->isLogged()){
            $id=$this->getUserId();
            $query = "UPDATE users SET username = :username WHERE id=$id;";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':username',$username);
            $stmt->execute();
            return true;
        }
    }
    function register($username,$email,$password){
        $password= password_hash($password,PASSWORD_DEFAULT);
        $query = "INSERT INTO users(username,email,password) VALUES(:username,:email, :password)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(":email",$email);
        $stmt ->bindParam(":password",$password);
        $stmt->execute();
        $_SESSION['login'] = $this->pdo->lastInsertId();
        
        header("Location:index.php");

    }
    function login($email, $password) {
        // Zapytanie do bazy danych
        $query = "SELECT id, password FROM users WHERE email = :email";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
    
        // Sprawdzanie, czy użytkownik istnieje
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($user) {
            // Sprawdzanie hasła
            if (password_verify($password, $user['password'])) {
                $_SESSION['login'] = $user['id']; 
                $this->id=$_SESSION['login'];
                return true; 
            } else {
                return false;  // Zwróć false, jeśli hasło jest błędne
            }
        } else {
            // Użytkownik o tym emailu nie istnieje
            return false;  // Zwróć false, jeśli nie znaleziono użytkownika
        }
    } 
    function getFriends(){
        $id= $this->getUserId();
        $query = "SELECT CASE 
                    WHEN user1 = :id THEN user2 
                    ELSE user1 
                END AS id
                FROM friends 
                
                WHERE (user1 = :id OR user2 = :id)
                AND status = 'accepted';";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        $friends = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $friends;


    }
    
    function getPendingFriends(){
        $id= $this->getUserId();
        $query = "SELECT user1 AS id
                FROM friends 
                WHERE user2 = :id
                AND status = 'pending';";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $requests;
       
}
}
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
}