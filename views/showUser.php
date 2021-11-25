<?php
    $access = false;
    $current_id = false;
    if (isset($_SESSION['access'])&&isset($_SESSION['id'])) {
        $access = $_SESSION['access'];
        $current_id = $_SESSION['id'];
}?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
                content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <link rel="stylesheet" href="assets/css/style.css">
        <style>
            body{
                padding-top: 3rem;
            }
            .container {
                width: 400px;
            }
        </style>
    </head>
    <body>
        <div id="progressbar"></div>
        <div id="scrollPath"></div>
        <section>
            <div class="container">
                <h3>Show User</h3>
                <div class="photo_container">
                    <img src="<?=$user['path_to_img']?>" alt="profile_photo" width="200px">
                </div>
                <form action="?controller=users&action=update" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?=$user['id']?>"/>
                    <input type="hidden" name="current_password" value="<?=$user['password']?>"/>
                    <div class="row">
                        <div class="field">
                            <label>First Name: <input type="text" name="first_name" required value="<?=$user['first_name']?>"><br></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="field">
                            <label>Second Name: <input type="text" name="second_name" required value="<?=$user['second_name']?>"><br></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="field">
                            <label>E-mail: <input type="email" name="email" value="<?=$user['email']?>"><br></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="field">
                            <?php if($access == 'admin' || $current_id == $user['id']):?>
                                <label>Password: <input type="password" name="password" minlength="6" value="<?=$user['password']?>"><br></label>
                            <?php endif ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="file-field input-field">
                            <div class="btn">
                                <span>Photo</span>
                                <input type="file" name="photo" accept="image/png, image/gif, image/jpeg">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text" name="path" value="<?=$user['path_to_img']?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="field">
                            <label>
                                <?php if($current_id != $user['id']):?>
                                    <input class="with-gap" type="radio" name="role" <?php if ($user['id_role'] == 1):?>checked<?php endif;?> value="admin"/>
                                    <span>Admin</span>
                                <?php else:?>
                                    <input class="with-gap" type="hidden" name="role" <?php if ($user['id_role'] == 1):?>checked<?php endif;?> value="admin"/>
                                <?php endif ?>

                            </label>
                        </div>
                        <div class="field">
                            <label>
                                <?php if($current_id != $user['id']):?>
                                    <input class="with-gap" type="radio" name="role" <?php if ($user['id_role'] == 2):?>checked<?php endif;?> value="user"/>
                                    <span>User</span>
                                <?php else:?>
                                    <input class="with-gap" type="hidden" name="role" <?php if ($user['id_role']== 2):?>checked<?php endif;?> value="user"/>
                                <?php endif ?>
                            </label>
                        </div>
                    </div>
                    <?php if($access == 'admin' || $current_id == $user['id']):?>
                        <input type="submit" class="btn" value="Save">
                        <a href="?controller=users&action=delete&id=<?=$user['id']?>" class="btn">Delete</a>
                    <?php endif ?>
                </form>
                <?php if(isset($_SESSION['id'])):?>
                    <div class="container">
                        <form action="?controller=users&action=leaveCom" method="post">
                            <input type="hidden" name="id" value="<?=$user['id']?>"/>
                            <input type="text" name="comment">
                            <input type="submit" class="btn" value="Leave comment">
                        </form>
                    </div>
                <?php endif ?>
                <div class="return">
                    <a class="btn" href="?controller=index">Return back</a>
                </div>

            </div>

            <div class="comment_area">
                <?php foreach ($comments as $comment):?>
                    <table>
                        <th>
                        <td><img src= "<?=$comment['path_to_img']?>" width="50px"></td>
                        <td><span><?=$comment['first_name']?></span></td>
                        <form action="?controller=users&action=changeCom" method="post">
                            <input type="hidden" name="user_id" value="<?=$user['id']?>"/>
                            <input type="hidden" name="id" value="<?=$comment['id']?>"/>
                            <td><input type="text" name="comment" value="<?=$comment['text']?>"></td>
                            <td><span><?=$comment['date']?></span></td>
                            <?php if($current_id == $comment['author_id']||$access == 'admin'):?>
                                <td><input type="submit" class="btn" value="Change"></td>
                            <?php endif?>
                        </form>
                        <?php if($access == 'admin'||$current_id == $comment['author_id']||$current_id==$user['id']):?>
                            <td><a href="?controller=users&action=deleteCom&id=<?=$comment['id']?>" class="btn">Delete</a></td>
                        <?php endif?>
                        </th>
                    </table>
                <?php endforeach ?>
            </div>
        </section>
        <script type="text/javascript">
            let progress = document.getElementById('progressbar');
            let totalHeight = document.body.scrollHeight - window.innerHeight;
            window.onscroll = function (){
                let progressHeight = (window.pageYOffset/totalHeight)*100;
                progress.style.height = progressHeight + "%";
            }
        </script>
    </body>
</html>
