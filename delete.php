<?php
error_reporting(0);
require_once('config.php');

if (isset($_GET["id"])) {
    $id = (int) $_GET["id"];
    $all = file_get_contents(DATA_FILE);
    $all = json_decode($all, true);
    $jsonfile = $all["users"];
    $jsonfile = $jsonfile["id_".$id];

    if ($jsonfile) {
        unset($all["users"]["id_".$id]);
        if(file_exists(IMG_ROOT.$jsonfile["image"])) {
            unlink(IMG_ROOT.$jsonfile["image"]);
        }
        file_put_contents(DATA_FILE, json_encode($all));
    }
    header("Location: ".BASE_URL."/index.php");
}