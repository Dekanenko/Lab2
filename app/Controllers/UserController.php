<?php
class UsersController{
    private $conn;
    public function __construct($db){
        $this->conn = $db->getConnect();
    }

    public function index(){
        include_once 'app/Models/UserModel.php';
        $str = filter_input(INPUT_POST, 'str', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if(isset($str)){
            $users = (new User())::all($this->conn, $str);
        }else{
            $users = (new User())::all($this->conn, '');
        }
        include_once 'views/users.php';
    }

    public function addForm(){
        include_once 'views/addUser.php';
    }

    public function add(){
        include_once 'app/Models/UserModel.php';
        include_once 'app/Help/uploadPhoto.php';
        $first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $second_name = filter_input(INPUT_POST, 'second_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = password_hash($password, PASSWORD_DEFAULT);
        $upload = new Upload();
        $filePath = $upload->getFilePath();
        if (trim($first_name) !== "" && trim($second_name) !== "" && trim($email) !== ""  && trim($password) !== "" && trim($role) !== "") {
            $user = new User($first_name, $second_name, $email, $password, $filePath, $role);
            $user->add($this->conn);
        }
        header('Location: ?controller=users');
    }

    public function show(){
        include_once 'app/Models/UserModel.php';
        if(!$_SESSION['reload']){
            $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            //$_SESSION['reload'] = false;
        }else{
            $id = $_SESSION['reload_id'];
        }

        if(trim($id) !== "" && is_numeric($id)){
            $user = (new User())::show_user_byId($this->conn, $id);
            $comments = (new User())::show_comments($this->conn, $id);
        }
        include_once 'views/showUser.php';
    }

    public function update(){
        include_once 'app/Models/UserModel.php';
        include_once 'app/Help/uploadPhoto.php';
        $first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $second_name = filter_input(INPUT_POST, 'second_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $current_password = filter_input(INPUT_POST, 'current_password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);;
        if($password!=$current_password){
            $password = password_hash($password, PASSWORD_DEFAULT);
        }
        $upload = new Upload();
        $filePath = $upload->getFilePath();
        if($upload->isUploaded()==false){
            $filePath = $_POST['path'];
        }
        if (trim($first_name) !== "" && trim($second_name) !== "" && trim($email) !== ""  && trim($password) !== "" && trim($role) !== "") {
            (new User())::update($this->conn, $id, $first_name, $second_name, $email, $password, $filePath, $role);
        }
        if($_SESSION['id']==$id){
            $_SESSION['fname'] = $first_name;
        }
        $_SESSION['reload'] = true;
        header('Location: ?controller=users&action=show');
        //header('Location: ?controller=users');
    }

    public function delete(){
        include_once 'app/Models/UserModel.php';
        include_once 'app/Models/IndexModel.php';
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if(trim($id) !== "" && is_numeric($id)){
            if($_SESSION['id']==$id){
                (new Index())::logout();
            }
            (new User())::delete($this->conn, $id);
        }
        header('Location: ?controller=users');
    }
    
    public function leaveCom(){
        include_once 'app/Models/UserModel.php';
        $comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $user_id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $author_id = $_SESSION['id'];
        $com_date = date("Y-m-d H:i:s");
        (new User())::leaveCom($this->conn, $user_id, $comment, $author_id, $com_date);

        $_SESSION['reload'] = true;
        header('Location: ?controller=users&action=show');
    }

    public function changeCom(){
        include_once 'app/Models/UserModel.php';
        $comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $com_date = date("Y-m-d H:i:s");
        (new User())::change_comments($this->conn, $id, $comment, $com_date);

        $_SESSION['reload'] = true;
        header('Location: ?controller=users&action=show');
    }

    public function deleteCom(){
        include_once 'app/Models/UserModel.php';
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        (new User())::delete_comments($this->conn, $id);

        $_SESSION['reload'] = true;
        header('Location: ?controller=users&action=show');
    }

}
