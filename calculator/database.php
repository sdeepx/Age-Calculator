<?php

define('HOST', '127.0.0.1');
define('UNMAE', 'root');
define('PASS', '');
define('DB', 'users_dob');

$conn = new mysqli(HOST, UNMAE, PASS);

if ($conn->connect_error) {
    die("connection failed: ".$conn->connect_error);
}
else {
    $db = "CREATE DATABASE users_dob";
    
    if ($conn->query($db) === TRUE) {
       
        $conn = new mysqli(HOST, UNMAE, PASS, DB);
        if ($conn->connect_error) {
            die("connection failed: ".$conn->connect_error);
        } 
        else {
            $table = "CREATE TABLE DOB(
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                dev_IP VARCHAR(200),
                birth_month VARCHAR(10),
                birth_date VARCHAR(10),
                birth_year VARCHAR(10),
                
                reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                )";

                if ($conn->query($table) === FALSE) {
                    echo "cannot create table: ".$conn->error;
                }
        }
        
    }
}

$conn->close();


?>
