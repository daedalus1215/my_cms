<?php 

// Declare and instantiate the variables.
$db['db_host'] = "localhost";
$db['db_user'] = "root";
$db['db_pass'] = "";
$db['db_name'] = "my_cms";

// CONSTANTS creation.
foreach ($db as $key => $value) {
    define(strtoupper($key), $value);
}

// Connect to db.
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Test connection.
if ($connection) { } 
else { echo "ERROR: We ARE NOT connected to db."; }

