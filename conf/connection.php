<?php

    $host = "localhost"; // mysql host
    $mysql_user = "root"; // mysql username
    $mysql_pass = "krittawat"; // mysql password
    $db = "engine"; // mysql schema

    $link = mysqli_connect("$host", "$mysql_user", "$mysql_pass", "$db");
    mysqli_set_charset($link,"utf8");
    
    if (!$link) {
        echo "Error: Unable to connect to MySQL.". PHP_EOL;
      //  echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
       // echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    } 
    
?>