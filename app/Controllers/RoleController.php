<?php
class RolesController{
   private $conn;
   public function __construct($db){
       $this->conn = $db->getConnect();
   }

   public function index(){
       include_once 'app/Models/RoleModel.php';
       $roles = (new Role())::all($this->conn);
       include_once 'views/roles.php';
   }

   public function addForm(){
    include_once 'views/addRole.php';
}

    public function add(){
        include_once 'app/Models/RoleModel.php';
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        echo $title;
        if (trim($title) !== "") {
            $role = new Role($title);
            $role->add($this->conn);
        }
        header('Location: ?controller=roles');
    }
 
    public function delete() {
        include_once 'app/Models/RoleModel.php';
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (trim($id) !== "" && is_numeric($id)) {
            (new Role())::delete($this->conn, $id);
        }
        header('Location: ?controller=roles');
    }

    public function update() {
        include_once 'app/Models/RoleModel.php';

        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (trim($title) !== "") {
            (new Role())::update($this->conn, $id, $title);
        }
        header('Location: ?controller=roles');
    }

    public function show(){
        include_once 'app/Models/RoleModel.php';
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (trim($id) !== "" && is_numeric($id)) {
            $role = (new Role())::byId($this->conn, $id);

        }
        include_once 'views/showRole.php';
    }
}
