<?php
class IndexController{
   private $conn;
   
   public function __construct($db){
        $this->conn = $db->getConnect();
   }

   public function index(){
       include_once 'views/home.php';
   }

    public function auth(){
    
        include_once 'app/Models/IndexModel.php';   
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (trim($email) !== "" && trim($password) !== "") {
            (new Index())::check($this->conn, $email, $password);
        }
   }

   public function logout(){
    
    include_once 'app/Models/IndexModel.php';  
    session_start();
    session_unset();
    session_destroy();
    header('Location: ?controller=index'); 

  }
}
