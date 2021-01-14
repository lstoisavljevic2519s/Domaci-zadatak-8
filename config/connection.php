<?php

require_once "config.php";

log_page_access();

try {
    $conn = new PDO("mysql:host=".SERVER.";dbname=".DATABASE.";charset=utf8", USERNAME, PASSWORD);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $ex){
    echo $ex->getMessage();
}

function executeQuery($query){
    global $conn;
    return $conn->query($query)->fetchAll();
}


function log_page_access(){
    $open = fopen(LOG_FILE, "a");
    if($open){
        fwrite($open, "{$_SERVER['PHP_SELF']}\t{$_SERVER['REMOTE_ADDR']}\n");
        fclose($open);
    }
}