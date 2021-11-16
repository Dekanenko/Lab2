<?php
class User {
   private $first_name;
   private $second_name;
   private $email;
   private $password;
   private $path_to_img;
   private $text_area;
   private $id_role;
   

    public function __construct($first_name = '', $second_name = '', $email = '', $password = '', $path_to_img = '', $text_area = '', $id_role = ''){
        $this->first_name = $first_name;
        $this->second_name = $second_name;
        $this->email = $email;
        $this->password = $password;
        $this->path_to_img = $path_to_img;
        $this->text_area = $text_area;
        $this->id_role = $id_role;
    }

    public function add($conn) {
        $sql = "INSERT INTO users (first_name, second_name, email, password, path_to_img, comment, id_role) VALUES ('$this->first_name', '$this->second_name', '$this->email', '$this->password', '$this->path_to_img', '$this->text_area', '1')";
        echo $sql;
        $res = mysqli_query($conn, $sql);
        if ($res) {
            return true;
        }
    }

   public static function all($conn) {
       $sql = "SELECT * FROM users";
       $result = $conn->query($sql);
       if ($result->num_rows > 0) {
           $arr = [];
           while ( $db_field = $result->fetch_assoc() ) {
               $arr[] = $db_field;
           }
           return $arr;
       } else {
           return [];
       }
   }

 
}
