<?php
class Admin{
 
    // database connection and table name
    private $conn;
    private $table_name = "admin";
 
    // object properties
    public $id;
    public $username;
    public $password;
    public $dibuat_pada;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    function login(){
        $sql = "SELECT password FROM " . $this->table_name . " WHERE username = ?";

        $stmtP = $this->conn->prepare($sql);

        $stmtP->bindParam(1, $this->username);

        $stmtP->execute();

        $row = $stmtP->fetch(PDO::FETCH_ASSOC);
        $this->password=htmlspecialchars(strip_tags($this->password));
      if(password_verify( $this->password,$row['password'] )){
        $sql2 = "SELECT id,username FROM " . $this->table_name . " WHERE username = ?";

        $stmt = $this->conn->prepare( $sql2 );

        $stmt->bindParam(1, $this->username);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        session_start();
        $_SESSION['id'] = $row['id'];
        $_SESSION['usernameAdmin'] = $row['username'];
        return true;
      }else{
        return false;
        
      }
    }
    
}