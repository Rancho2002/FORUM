<?php
$login = "false";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "_dbconnect.php";
    $user = $_POST["username"];
    $pass = $_POST["password"];

    $sql = "SELECT * FROM `users` where `username`='$user'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    // echo $num;
    if ($num == 1) {
        while ($a = mysqli_fetch_assoc($result)) {
            // var_dump($a['password']);
            // echo $pass;
            // echo $a['password'];
            // $hash=password_verify($pass, $a["password"]);
            // echo var_dump($hash);.//!Important lesson: Always set password field as 255 in phpmyadmin:)

            $sno=$a['user_id'];
            if ($pass == password_verify($pass, $a['password'])) {
                session_start();
                $login = "true";
                $_SESSION["username"]=$user;
                $_SESSION['sno']=$sno;
                $_SESSION["login"]=true;
            }
            else {
                $login = "wrong";
            }
    } 
    }else 
    {
        $login = "false";

    }   
}
header("location: /forum/index.php?login=" . $login);
?>