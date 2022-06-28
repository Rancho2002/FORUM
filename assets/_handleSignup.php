<?php
$signup="undefine";
if($_SERVER["REQUEST_METHOD"]=="POST"){
    include "_dbconnect.php";
    $username=$_POST["username"];
    $pass=$_POST["password"];
    $cpass=$_POST["cpassword"];

    $checkSql="SELECT * FROM `users`";
    $checkResult=mysqli_query($conn,$checkSql);
    $userId=mysqli_num_rows($checkResult)+1;

    $existSql="SELECT * FROM `users` where `username`='$username'";
    $result=mysqli_query($conn,$existSql);
    $numRow=mysqli_num_rows($result);
    if($numRow>0){
        $showError="Username already exists";
        $signup="exist";
    }
    else{
        if($pass==$cpass){

            $hash=password_hash($pass,PASSWORD_DEFAULT);
            $sql="INSERT INTO `users` (`user_id`,`username`, `password`, `timestamp`) VALUES ('$userId','$username', '$hash', current_timestamp())";
            $result=mysqli_query($conn,$sql);
            if($result){
                $signup="true";
            }
            
        }
        else{
            $showError="Password and Confirm Password are not same";
            $signup="notsame";
        }
    }
}

header("location: /forum/index.php/?signup=".$signup);