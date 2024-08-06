<?php 
error_reporting(0);
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tierchart";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if($conn){
    // echo"connection is established";
}else{
    echo"connection with database is not established";
}
?>