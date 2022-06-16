<?php
session_start();
require_once "../config.php";

//register users
function registerUser($fullnames, $email, $password, $gender, $country){
    //create a connection variable using the db function in config.php
    $conn = db(); 
   //check if user with this email already exist in the database
   $sql = "SELECT email FROM Students WHERE email = '$email'";
   $commit = mysqli_query($conn, $sql);
     if ($commit){
        if (mysqli_num_rows($commit)>0){
        echo "<script> alert('User exists');</script>";
        }else{
            $insert_user = "INSERT INTO `Students`(`full_names`, `country`, `email`, `gender`, `password`) VALUES ('$fullnames', '$country', '$email', '$gender','$password')";
            $commitUser = mysqli_query($conn, $insert_user);
            if ($commitUser) {
                echo "<script> alert('User Successfully registered');</script>";
                header("Location:../forms/login.html");
            }
        }
    }
}

//login users
function loginUser($email, $password){
    //create a connection variable using the db function in config.php
    $conn = db();

    // echo "<h1 style='color: red'> LOG ME IN (IMPLEMENT ME) </h1>";
    //open connection to the database and check if username exist in the database
    //if it does, check if the password is the same with what is given
    //if true then set user session for the user and redirect to the dasbboard
    $sql = "SELECT `full_names`,`email`,  `password` FROM `Students` WHERE `email` = '$email'";
    $commit = mysqli_query($conn, $sql);
    if ($commit){
        if(mysqli_num_rows($commit)>0){
            $column = mysqli_fetch_assoc($commit);
            $passcode = $column ['password'];
            $full_names = $column ['full_names'];
            if($passcode == $password){
                $_SESSION["full_names"] = $full_names;
                header("Location:../dashboard.php");
            }else{
                header("Location:../forms/login.html");
            }
        }
    }
}


function resetPassword($email, $password){
    //create a connection variable using the db function in config.php
    $conn = db();
    // echo "<h1 style='color: red'>RESET YOUR PASSWORD (IMPLEMENT ME)</h1>";
    //open connection to the database and check if username exist in the database
    //if it does, replace the password with $password givenf
    $sql = "UPDATE Students SET password = '$password' WHERE email= '$email'" ;
    if (mysqli_query($conn, $sql) ){
        if(mysqli_num_rows($commit)>0){
            echo "<script> alert('password updated successfully');</script>";
            header("Location:../forms/login.html");
        }else{
            echo "<script> alert('User does not exist');</script>";
            header("Location:../dashboard.php");
        }
    } 
}

function getusers(){
    $conn = db();
    $sql = "SELECT * FROM Students";
    $result = mysqli_query($conn, $sql);
    echo"<html>
    <head></head>
    <body>
    <center><h1><u> ZURI PHP STUDENTS </u> </h1> 
    <table border='1' style='width: 700px; background-color: magenta; border-style: none'; >
    <tr style='height: 40px'><th>ID</th><th>Full Names</th> <th>Email</th> <th>Gender</th> <th>Country</th> <th>Action</th></tr>";
    if(mysqli_num_rows($result) > 0){
        while($data = mysqli_fetch_assoc($result)){
            //show data
            echo "<tr style='height: 30px'>".
                "<td style='width: 50px; background: blue'>" . $data['id'] . "</td>
                <td style='width: 150px'>" . $data['full_names'] .
                "</td> <td style='width: 150px'>" . $data['email'] .
                "</td> <td style='width: 150px'>" . $data['gender'] . 
                "</td> <td style='width: 150px'>" . $data['country'] . 
                "</td>
                <form action='action.php' method='post'>
                <input type='hidden' name='id'" .
                 "value=" . $data['id'] . ">".
                "<td style='width: 150px'> <button type='submit', name='delete'> DELETE </button>".
                "</tr>";
        }
        echo "</table></table></center></body></html>";
    }
    //return users from the database
    //loop through the users and display them on a table
}

 function deleteaccount($id){
    $conn = db();
    //delete user with the given id from the database
    $sql = "DELETE FROM `Students` WHERE `id` = '$id'";
    if (mysqli_query($conn, $sql) ) {
        echo "<script> alert('user deleted successfully');</script>";
        header("Location:../dashboard.php");
    }
 }
?>