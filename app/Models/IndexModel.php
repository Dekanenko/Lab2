<?php
class Index {

    public function __construct(){

    }

    public static function check($conn, $email, $password) {
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($sql);
        if ($result->num_rows>0) {
            while($row = $result->fetch_assoc()){
                if($row['password']==$password){
                    $_SESSION["auth"] = true;
                    echo $_SESSION["auth"];
                }
            }
            
        }
        header('Location:?controller=users&action=addForm');
    }

 
}
