<?php
    $access = false;
    $_SESSION['reload'] = false;
    if (isset($_SESSION['access'])) {
        $access = $_SESSION['access'];
        $name = $_SESSION['fname'];
        $user_id = $_SESSION['id'];
}?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" integrity="sha512-NhSC1YmyruXifcj/KFRWoC561YpHpc5Jtzgvbuzx5VozKpWvQ+4nXhPdFgmx8xqexRcpAglTj9sIBWINXa8x5w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .container {
            width: 400px;
        }
    </style>

    <script>
        window.onload = function() {
            clear.addEventListener('click', ()=>{
                let text = document.getElementById("str")
                text.value = "";
            })
            let x = 0;
            signIn.addEventListener('click', ()=>{
                form = document.getElementById("popUp_form");
                if(x==0){
                    form.style.display = "block";
                    x = 1;
                }else{
                    form.style.display = "none";
                    x = 0;
                }
            })
        };
    </script>

</head>
    <body style="padding-top: 3rem;">
        <div class="header">
            <div class="popUp" id="popUp_form">
                <div class="container">
                    <h1>Log In</h1>
                    <form action="?controller=index&action=login" method="post">
                        <div class="row">
                            <div class="field">
                                <label>E-mail: <input type="email" name="email"><br></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="field">
                                <label>Password: <input type="password" name="password"><br></label>
                            </div>
                        </div>
                        <input type="submit" class="btn" value="Enter">
                    </form>
                </div>
            </div>

            <div class="head_container">
                <?php if($access):?>
                    <a href="?controller=users&action=show&id=<?=$user_id?>" class="logName"><?=$name?></a>
                    <a href="?controller=index&action=logout" class="btn">Sign Out</a>
                <?php else:?>
                    <input id="signIn" type="button" value="Sign In" class="btn">
                    <a href="?controller=users&action=addForm" class="btn">Sign Up</a>
                <?php endif ?>
                </div>
            <div class="search_container">
                <form action="?controller=users&action=index" method="post">
                    <input id="str" type="text" name="str" value="">
                    <input type="submit" class="btn" value="Search">
                    <input id="clear" type="button" value="Clear" class="btn">
                </form>
            </div>

        </div>
        <div class="container">
        <div class="row">
            <table>
                <tr>
                    <th></th>
                    <th>#</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Role</th>
                </tr>
                <?php foreach ($users as $user):?>
                    <tr>
                        <td><img src="<?=$user['path_to_img']?>" alt="profile_photo" width="50px"></td>
                        <td> <a href="?controller=users&action=show&id=<?=$user['id']?>"><?=$user['id']?></a></td>
                        <td><?=$user['first_name']?></td>
                        <td><?=$user['second_name']?></td>
                        <td><?=$user['email']?></td>
                        <td><?=$user['title']?></td>
                    </tr>
                <?php endforeach;?>
            </table>
        </div>

         <a class="btn" href="?controller=index">Return back</a>
         <?php if($access === 'admin'):?>
            <a class="btn" href="?controller=users&action=addForm">Add user</a>
        <?php endif ?>
        </div>
    </body>
</html>
