<?php
error_reporting(0);
require_once('config.php');

if (isset($_POST["id"])) {
    $id = (int) $_POST["id"];
    $all = file_get_contents(DATA_FILE);
    $all = json_decode($all, true);
    $jsonfile = $all["users"];
    $jsonfile = $jsonfile["id_".$id];
    $response = [];
    if ($jsonfile) {
        $file = $jsonfile['image'];
        if(preg_match('/^[^.][-a-z0-9_.]+[a-z]$/i', $file)){
            $filepath = IMG_ROOT . $jsonfile['image'];
            // Process download
            if(file_exists($filepath)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($filepath));
                flush(); // Flush system output buffer
                readfile($filepath);
            } else {
                echo json_encode(["error_msg" => "File not exists"]);
            }
        } else {
            echo json_encode(["error_msg" => "Invalid file name!"]);
        }
    }
}