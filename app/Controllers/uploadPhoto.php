<?php
	$target_dir = "public/uploads/";
    $target_file = $target_dir . basename($_FILES["photo"]["name"]);
    $isUploaded = false;
    $filePath = 'public/uploads/default.png';

    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    if(($_FILES["photo"]["tmp_name"])){
        $check = getimagesize($_FILES["photo"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $isUploaded = true;
        } else {
            echo "File is not an image.";
            $isUploaded = false;
        }
    }

    if ($_FILES["photo"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $isUploaded = false;
    }
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry,onlyJPG,JPEG,PNG&GIF files are allowed.";
        $isUploaded = false;
    }
    
    if ($isUploaded == false) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            echo "The file has been uploaded.";
            $filePath = $target_dir . basename($_FILES["photo"]["name"]);
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }