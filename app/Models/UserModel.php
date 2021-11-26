<?php
class User {
    private $first_name;
    private $second_name;
    private $email;
    private $password;
    private $path_to_img;
    private $role;
   

    public function __construct($first_name = '', $second_name = '', $email = '', $password = '', $path_to_img = '', $role = ''){
        $this->first_name = $first_name;
        $this->second_name = $second_name;
        $this->email = $email;
        $this->password = $password;
        $this->path_to_img = $path_to_img;
        $this->role = $role;
    }

    public function add($conn) {
        $sql = "SELECT id FROM roles WHERE title = '$this->role'";
        $res = mysqli_query($conn, $sql);
        if (!$res) {
            return false;
        }
        $id_role = $res->fetch_assoc()['id'];
        $sql = "INSERT INTO users (first_name, second_name, email, password, path_to_img, id_role) VALUES ('$this->first_name', '$this->second_name', '$this->email', '$this->password', '$this->path_to_img', '$id_role')";
        $res = mysqli_query($conn, $sql);
        if ($res) {
            return true;
        }else{
            echo "Invalid data\n";
        }
    }

    public static function all($conn, $str) {
        if($str!=''){
            $sql = "SELECT users.id, users.first_name, users.second_name, users.email, users.path_to_img, roles.title FROM users LEFT JOIN roles ON users.id_role=roles.id WHERE first_name LIKE '%$str%' OR second_name LIKE '%$str%'";
        }else{
            $sql = "SELECT users.id, users.first_name, users.second_name, users.email, users.path_to_img, roles.title FROM users LEFT JOIN roles ON users.id_role=roles.id";
        }
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

    public static function show_user_byId($conn, $id){
        $sql = "SELECT * FROM users WHERE id = '$id'";
        $result = mysqli_query($conn, $sql);
        if($result->num_rows>0){
            $arr = $result->fetch_assoc();
            $_SESSION['reload_id'] = $arr['id'];
            return $arr;

        }else{
            return [];
        }
    }

    public static function update($conn, $id, $first_name, $second_name, $email, $password, $path_to_img, $role){
        $sql = "SELECT * FROM roles WHERE title = '$role'";
        $result = mysqli_query($conn, $sql);
        if($result){
           $id_role = $result->fetch_assoc()['id'];
           $sql = "UPDATE users SET first_name = '$first_name', second_name = '$second_name', email = '$email', password = '$password', path_to_img = '$path_to_img', id_role = '$id_role' WHERE id = '$id'"; 
           $result = mysqli_query($conn, $sql);
           if($result){
               return true;
               $_SESSION['reload_id'] = $id;
           }
        }
    }

    public static function delete($conn, $id){
        $sql = "DELETE FROM comments WHERE user_id = '$id'";
        $res = mysqli_query($conn, $sql);
        if($res){
            $sql = "DELETE FROM comments WHERE author_id = '$id'";
            $res = mysqli_query($conn, $sql);
            if($res){
                $sql = "DELETE FROM users WHERE id = '$id'";
                $res = mysqli_query($conn, $sql);
                if($res){
                    return true;
                }
            }
        }
    }

    public static function leaveCom($conn, $user_id, $comment, $author_id, $com_date){
        $sql = "INSERT INTO comments (author_id, text, user_id, date) VALUES ('$author_id', '$comment', '$user_id', '$com_date')";
        $result = mysqli_query($conn, $sql);
        if($result){
            return true;
        }
    }

    public static function show_comments($conn, $id){
        $sql = "SELECT comments.id, comments.author_id, comments.text, comments.date, users.first_name, users.path_to_img FROM comments LEFT JOIN users ON comments.author_id=users.id WHERE user_id = '$id'";
        $result = mysqli_query($conn, $sql);
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

    public static function change_comments($conn, $id, $comment, $com_date){
        $sql = "UPDATE comments SET text = '$comment', date = '$com_date' WHERE id = '$id'";
        $result = mysqli_query($conn, $sql);
        if($result){
            return true;
        }
    }

    public static function delete_comments($conn, $id){
        $sql = "DELETE FROM comments WHERE id = '$id'";
        $result = mysqli_query($conn, $sql);
        if($result){
            return true;
        }
    }

}
