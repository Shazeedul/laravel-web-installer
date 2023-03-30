<?php

ini_set('max_execution_time', 300); // increase max_execution_time to 300 seconds (5 minutes)
chdir(dirname(__DIR__)); // change current directory to project root
$output = array();
exec('composer install', $output);
exec('php artisan key:generate', $output);
print_r($output);
