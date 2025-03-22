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
        $query = "SELECT 
        CASE 
            WHEN user1 = :id THEN user2 
            ELSE user1 
        END AS id

    FROM friends 
    WHERE (user1 = :id OR user2 = :id) 
      AND status = 'accepted'
    ORDER BY (SELECT sent_at 
         FROM messages 
         WHERE (sender_id = :id AND receiver_id = CASE WHEN user1 = :id THEN user2 ELSE user1 END)
            OR (sender_id = CASE WHEN user1 = :id THEN user2 ELSE user1 END AND receiver_id = :id) 
         ORDER BY sent_at DESC 
         LIMIT 1) DESC;
";

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
    function accepptRequest($request){
        $query = "UPDATE friends SET status = 'accepted' WHERE user1 = :request AND user2 = :id";
        $id= $this->getUserId();
        $stmt = $this->pdo->prepare($query);
        $stmt-> bindParam(':id',$id);
        $stmt-> bindParam(':request',$request);
        $stmt-> execute();
        
        return true;
  

    }   
    function denyRequest($request){
        $query = "DELETE FROM friends WHERE user1 = :request AND user2 = :id AND status = 'pending'";
        $id= $this->getUserId();
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':request', $request);
        $stmt->execute();
        return true;
    }
    function logout(){
        session_destroy();
        header("Location:index.php");
    }
    function status($id,$status){
        $query = "UPDATE users SET status = :status WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':status',$status);
        $stmt->bindParam(':id',$id);
        $stmt->execute();
    }
    function setTheme($theme){
        $id = $this->id;
        $query = "UPDATE users SET theme = :theme WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':theme',$theme);
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        
    }
    function getJoinDate(){
        $id = $this->id;
        $query = "SELECT created_at FROM users WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['created_at'];
    }


}