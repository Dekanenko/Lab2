<?php
class IndexController{
   private $conn;
   
   public function __construct($db){
        $this->conn = $db->getConnect();
   }

   public function index(){
       header('Location:?controller=users');
   }

    public function login(){
        include_once 'app/Models/IndexModel.php';   
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (trim($email) !== "" && trim($password) !== "") {
            (new Index())::check($this->conn, $email, $password);
        }
        header('Location:?controller=users');
   }

    public function logout(){
    
    include_once 'app/Models/IndexModel.php';  
    (new Index())::logout();
    header('Location: ?controller=index'); 
  }
}
