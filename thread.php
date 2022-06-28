<?php
include "assets/_dbconnect.php";

$commentInsert = false;
$threadid = $_GET['threadid'];
$sql = "SELECT * FROM `threads` WHERE `thread_id`=$threadid";

$result = mysqli_query($conn, $sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // $user
    $comment_desc = $_POST["comment"];
    $sno=$_POST["sno"];
    $sqlInsert = "INSERT INTO `comments` (`comment_by`, `comment_desc`, `thread_id`, `comment_time`) VALUES ('$sno', '$comment_desc', '$threadid', current_timestamp())";
    $commentInsert = mysqli_query($conn, $sqlInsert);
}
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
    if ($commentInsert) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Your comment added successfully to the discussion forum.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    }
    ?>
    <div class="container">
        <?php

        $a = mysqli_fetch_assoc($result);
        $thread_user_id = $a['user_id'];
        $userSql = "SELECT * FROM `users` where `user_id`='$thread_user_id'";
        $userResult = mysqli_query($conn, $userSql);
        $userArr = mysqli_fetch_assoc($userResult);
        echo '<div class="jumbotron">
            <h2>' . $a['thread_title'] . '</h2>
            <p class="text-dark">' . $a['thread_desc'] . '
            </p>
            <hr class="my-4">
            <b>Some guidelines you must have to follow before joining the discussion: </b>
            <ul class="mt-2">
                <li >No Spam / Advertising / Self-promote in the forums. ...</li>
                <li>Do not post “offensive” posts, links or images. ...</li>
                <li>Do not cross post questions. ...</li>
                <li>Do not PM users asking for help. ...</li>
                <li>Remain respectful of other members at all times.</li>
            </ul>

            <p class="btn btn-success btn-lg">Posted by <i>' . $userArr['username'] . '</i></p>
        </div>';
        ?>
        
        <?php
        if (isset($_SESSION["login"]) &&  $_SESSION["login"] == true) {
            echo '<div>
            <form action="' . $_SERVER["REQUEST_URI"] . '" method="POST">
            <div class="form-group">
            <label for="comment">Type your comment</label>
            <input type="hidden" name="sno" value="'.$_SESSION['sno'].'">
            <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
            <small id="emailHelp" class="form-text text-muted">make sure you follow the rules and regulations of the forum <span class="text-danger">*</span></small>
        </div>
                <button type="submit" class="btn btn-success mb-2">Submit</button>
            </form>
        ';
        } else {
            echo '<h3 class="lead text-center my-3 display-4">You are not logged in!<a href="" data-toggle="modal" data-target="#loginModal"> Login </a>to post comments.</h3>';
        }
        ?>
        <h2 class="my-3">Discussions</h2>


        <?php
        $noDiscuss = true;
        $sql = "SELECT * FROM `comments` where `thread_id`=$threadid";
        $result = mysqli_query($conn, $sql);
        while ($comment = mysqli_fetch_assoc($result)) {
            $comment_user_id = $comment['comment_by'];

            $userSql = "SELECT * FROM `users` where `user_id`='$comment_user_id'";
            $userResult = mysqli_query($conn, $userSql);
            $userArr = mysqli_fetch_assoc($userResult);

            echo '<div class="media mt-3">
                <img src="/forum/assets/img/userlogo.png" width="40px" class="mr-3" alt="...">
                    <div class="media-body">
                    <h5 class="mt-0 d-inline">' . $userArr['username'] . '</h5><span class="font-weight-bold font-italic"> commented at ' . $comment["comment_time"] . '</span>
                    <p>' . $comment['comment_desc'] . '</p>
                    </div>
                </div>';
            $noDiscuss = false;
        }
        if ($noDiscuss) {
            echo ' <hr>
                    <div class="text-center">
                    <h4>No discussion started right now</h4>
                    <p>Be the first one to start.</p>
                    </div>
                 ';
        }

        ?>

    </div>

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