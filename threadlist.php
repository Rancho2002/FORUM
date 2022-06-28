<?php
include "assets/_dbconnect.php";
$resultInsert = false;

$catid = $_GET['catid'];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $thread_title = $_POST["title"];
    $thread_desc = $_POST["desc"];
    $sno=$_POST["sno"];
    $insertSql = "INSERT INTO `threads` ( `thread_title`, `thread_desc`, `cat_id`, `user_id`, `thread_date`) VALUES ( '$thread_title', '$thread_desc', '$catid', '$sno', current_timestamp())";
    $resultInsert = mysqli_query($conn, $insertSql);
    // echo $result;
    // $insert = true;
}

$sql = "SELECT * FROM `category` WHERE `sl`=$catid";

$result = mysqli_query($conn, $sql);
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/style.css">

    <title>iForum- Online Coding Discussion</title>
</head>

<body>

    <?php
    require "assets/_header.php";

    if ($resultInsert) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Your thred is now public. Keep patience, someone will start discussion soon.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    }
    ?>
    <div class="container">
        <?php

        while ($a = mysqli_fetch_assoc($result)) {
            echo '<div class="jumbotron">
            <h1>Welcome to ' . $a['category_name'] . ' forums</h1>
            <p class="lead">' . $a['category_description'] . '
            </p>
            <hr class="my-4">
            <b>Some guidelines you must have to follow : </b>
            <ul class="mt-2">
                <li>No Spam / Advertising / Self-promote in the forums. ...</li> 
                <li>Do not post “offensive” posts, links or images. ...</li>
                <li>Do not cross post questions. ...</li>
                <li>Do not PM users asking for help. ...</li>
                <li>Remain respectful of other members at all times.</li>
            </ul>';
        }
        ?>
        <?php
        if (isset($_SESSION["login"]) &&  $_SESSION["login"] == true) {
            echo '<a class="btn btn-success btn-lg" href="#title" id="askQ" role="button" >Post a thread</a> ';
        } else {
            echo '<a class="btn btn-success btn-lg" href="" id="askQ" role="button" data-toggle="modal" data-target="#mustLogin">Post a thread</a> 
        ';
        }
        ?>
    </div>
    <h2 class="my-3">Browse Questions</h2>

    <?php
    $catid = $_GET['catid'];
    $sql = "SELECT * FROM `threads` WHERE `cat_id`=$catid";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if ($num) {
        while ($thread = mysqli_fetch_assoc($result)) {
            $thread_user_id=$thread['user_id'];
            $id = $thread['thread_id'];

            $userSql="SELECT * FROM `users` where `user_id`='$thread_user_id'";
            $userResult=mysqli_query($conn,$userSql);
            $userArr=mysqli_fetch_assoc($userResult);

            echo '<div class="media mt-3">
            <img src="/forum/assets/img/userlogo.png" width="40px" class="mr-3" alt="...">
                <div class="media-body">
                <h5 class="mt-0 d-inline">'.$userArr['username'].'</h5><span class="font-italic"> posted at '.$thread['thread_date'].'</span><br>
                <b><a href="/forum/thread.php/?threadid=' . $id . '" class="text-dark">' . $thread['thread_title'] . '</a></b>
                
                <p>' . $thread['thread_desc'] . '</p>
                </div>
            </div>';
        }
    } else {
        echo ' <hr>
        <div class="text-center">
        <h4>No Questions are asked till now</h4>
        <p>Be the first one to ask</p>
        </div>
           ';
    }
    echo "<hr>";

    ?>


    <?php
    if (isset($_SESSION["login"]) &&  $_SESSION["login"] == true) {
        echo '<div>
            <form action="'.$_SERVER["REQUEST_URI"].'" method="POST">
                <div class="form-group">
                    <label for="title">Thread title</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="e.g. Can I use VS code for all languages?" maxlength="200" required>
                </div>
                <input type="hidden" name="sno" value="'.$_SESSION['sno'].'">
                <div class="form-group">
                    <label for="desc">Elaborate your concern</label>
                    <textarea class="form-control" id="desc" name="desc" rows="3" placeholder="elaborate as clearly as possible" required></textarea>
                </div>
                <button type="submit" class="btn btn-success mb-2">Submit</button>
            </form>
        </div>';
    } else {
        echo '<h3 class="lead text-center my-3">You are not logged in! Login to post thread.</h3>';
    }
    ?>




    </div>
    <?php
    require "assets/_footer.php";

    ?>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>

</body>

</html>