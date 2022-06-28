<?php
$server="localhost";
$username="root";
$password="";
$database="iforum";

$conn=mysqli_connect($server,$username,$password,$database);

if(!$conn){
    echo "<h1 style='color:red'>Failed to connect to DB</h1>";
}
?>