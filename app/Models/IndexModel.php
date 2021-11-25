<?php
class Index {

    public function __construct(){

    }

    public static function check($conn, $email, $password) {
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($sql);
        if ($result->num_rows>0) {
            while($row = $result->fetch_assoc()){
                if(password_verify($password, $row['password'])){
                    $id = $row['id_role'];  
                    $sql = "SELECT * FROM roles WHERE id = '$id'";
                    $res = $conn->query($sql);
                    if($res->num_rows > 0){
                        $_SESSION["access"] = $res->fetch_assoc()['title'];
                        $_SESSION["fname"] = $row['first_name'];
                        $_SESSION["id"] = $row['id'];
                    }      
                }
            }
        }
    }

    public static function logout(){
        session_start();
        session_unset();
        session_destroy();
    }

 
}
