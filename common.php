<?php
    error_reporting(0);
    include('config.php');
    $json_data = [];
    if(file_exists(DATA_FILE)) {
        $get_file = file_get_contents(DATA_FILE);
        $json_data = json_decode($get_file);
    }
?>