<?php
require_once('config.php');

function upload_image_file($file, $file_name='') {
    $imgFile = $file['name'];
    $tmp_dir = $file['tmp_name'];
    $imgSize = $file['size'];

    if (!empty($imgFile)) {
        $upload_dir = IMG_ROOT; // upload directory
        $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension

        // valid image extensions
        $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions

        // rename uploading image
        if(empty($file_name)) {
            $coverpic = rand(1000, 1000000) . "." . $imgExt;
        } else {
            $coverpic = $file_name. "." . $imgExt;
        }

        // allow valid image file formats
        if (in_array($imgExt, $valid_extensions)) {
            // Check file size '5MB'
            if ($imgSize < 5000000) {
                move_uploaded_file($tmp_dir, $upload_dir . $coverpic);
                return ['status' => true, 'file_name' => $coverpic];
            } else {
                $errMSG = "Sorry, your image file is too large.";
            }
        } else {
            $errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        }
        return ['status' => false, 'error_msg' => $errMSG];
    }
}

?>