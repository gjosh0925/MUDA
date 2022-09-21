<?php

date_default_timezone_set('America/Chicago');

include_once 'environment.php';

global $config;
define("INC_PATH", $config['system_path'] . '/includes');

foreach (glob(INC_PATH . "/models/*.php") as $filename) {
    include_once $filename;
}


include_once 'mysql.php';