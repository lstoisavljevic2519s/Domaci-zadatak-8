<?php
define('BASE_URL', 'http://localhost/domaci8/');
define('ABSOLUTE_PATH', $_SERVER['DOCUMENT_ROOT']);

//Others
define('ENV_FILE', ABSOLUTE_PATH.'/domaci8/config/.env');
define('LOG_FILE', ABSOLUTE_PATH.'/domaci8/config/log.txt');

// Db settings
define("SERVER", env("SERVER"));
define("DATABASE", env("DBNAME"));
define("USERNAME", env("USERNAME"));
define("PASSWORD", env("PASSWORD"));

function env($name){
    $open = fopen(ENV_FILE, "r");
    $data = file(ENV_FILE);
    $value = "";
    foreach($data as $key=>$val){
        $config = explode("=", $val);
        if($config[0]==$name){
            $value = trim($config[1]); 
        }
    }
    return $value;
}
