<?php

    Class Upload{
        private $target_dir = "public/uploads/";
        private $target_file;// = $target_dir . basename($_FILES["photo"]["name"]);
        public $isUploaded = false;
        public $filePath = 'public/uploads/default.png';

        public function __construct(){
            $this->target_file = $this->target_dir . basename($_FILES["photo"]["name"]);
            $imageFileType = strtolower(pathinfo($this->target_file,PATHINFO_EXTENSION));

            if(($_FILES["photo"]["tmp_name"])==''){
                return;
            }

            if(($_FILES["photo"]["tmp_name"])){
                $check = getimagesize($_FILES["photo"]["tmp_name"]);
                if($check !== false) {
                    echo "File is an image - " . $check["mime"] . ".";
                    $this->isUploaded = true;
                } else {
                    echo "File is not an image.";
                    $this->isUploaded = false;
                }
            }

            if ($_FILES["photo"]["size"] > 500000) {
                echo "Sorry, your file is too large.";
                $this->isUploaded = false;
            }
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" ) {
                echo "Sorry,onlyJPG,JPEG,PNG&GIF files are allowed.";
                $this->isUploaded = false;
            }

            if ($this->isUploaded == false) {
                echo "Sorry, your file was not uploaded.";
            } else {
                if (move_uploaded_file($_FILES["photo"]["tmp_name"], $this->target_file)) {
                    echo "The file has been uploaded.";
                    $this->filePath = $this->target_dir . basename($_FILES["photo"]["name"]);
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }

        public function getFilePath(){
            return $this->filePath;
        }

        public function isUploaded(){
            return $this->isUploaded;
        }
    }
