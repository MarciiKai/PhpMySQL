<?php


function db() {
    //set your configs here
    $host = "localhost";
    $user = "USERNAME";
    $db = "Zuriphp";
    $password = "PASSWORD";
    $conn = mysqli_connect($host, $user, $password, $db);
    if(!$conn){
        echo "<script> alert('Error connecting to the database') </script>";
    }
    return $conn;

}
?>