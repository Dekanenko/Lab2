<?php
class UsersController{
   private $conn;
   public function __construct($db){
       $this->conn = $db->getConnect();
   }

   public function index(){
       include_once 'app/Models/UserModel.php';
       $users = (new User())::all($this->conn);

       include_once 'views/users.php';
   }

   public function addForm(){
       include_once 'views/addUser.php';
   }

   public function add(){
       include_once 'app/Models/UserModel.php';
       include_once 'app/Controllers/uploadPhoto.php';
       $first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
       $second_name = filter_input(INPUT_POST, 'second_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
       $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
       $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
       $text_area = filter_input(INPUT_POST, 'text_area', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
       $id_role = filter_input(INPUT_POST, 'id_role', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
       if (trim($first_name) !== "" && trim($second_name) !== "" && trim($email) !== ""  && trim($password) !== "") {
           $user = new User($first_name, $second_name, $email, $password, $filePath, $text_area, $id_role);
           $user->add($this->conn);
       }
       header('Location: ?controller=users');
   }

}
