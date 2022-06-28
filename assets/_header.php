<?php
$login=false;
session_start();


echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="/forum">iForum</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="/forum">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/forum/about.php">About</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
          Categories
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        ';
        ?>
        <?php
        include "_dbconnect.php";
        $catsql="Select * from `category`";
        $catresult=mysqli_query($conn,$catsql);

        while($row=mysqli_fetch_assoc($catresult)){
        echo '<a class="dropdown-item" href="/forum/threadlist.php/?catid='.$row['sl'].'">'.$row["category_name"].'</a><br>';
        }
  
        ?>
        <?php
        echo '<div class="dropdown-divider"></div>
          <a class="dropdown-item" href="https://www.youtube.com/channel/UCDmB9yl8aKCT0fP5Abb7wnw/videos" target="_blank">Subscribe my channel :)</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link " href="/forum/contact.php">Contact Us</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0 mr-2">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <a class="btn btn-success my-2 my-xm-0 mr-1">Search</a>
    </form>
    ';
if (isset($_SESSION["login"]) &&  $_SESSION["login"] == true) {

  echo '<div class="row">
      <img src="/forum/assets/img/userlogo.png" class="mx-2" width="43px" alt="' . $_SESSION["username"] . '"><span class="text-light m-auto">' . $_SESSION["username"] . '</span>
        <a href="/forum/assets/_logout.php" class="text-light"><img src="/forum/assets/img/logout.png" class="mx-2" width="35px" alt="logout" title="logout"></a>
    </div>';
}

else {
  echo '<div class="row">
        <button type="button" class="btn btn-outline-success ml-3  mr-2" data-toggle="modal" data-target="#loginModal" id="login">Login</button>
        <button class="btn btn-outline-success mr-1" data-toggle="modal" data-target="#signupModal">Sign Up</button>
    </div>';
}
echo '</div>
</nav>';

include "_loginmodal.php";
include "_signupmodal.php";
include "_mustLogin.php";



if (isset($_GET["signup"])) {
  $signup = $_GET["signup"];

  if ($signup == "true") {
    echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
  <strong>Success!</strong> Your account created successfully. <a href="" data-toggle="modal" data-target="#loginModal">You can login now</a>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
  }
  if ($signup == "exist") {
    echo '<div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
  <strong>Sorry!</strong> Username already exists.  <a href="" data-toggle="modal" data-target="#loginModal">Try to login</a>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
  }
  if ($signup == "notsame") {
    echo '<div class="alert alert-warning alert-dismissible fade show my-0" role="alert">
  <strong>Error!</strong> Password & confirm password not match.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
  }
}

if (isset($_GET["login"])) {
  $loginMsg = $_GET["login"];
  $showError = false;



  if ($loginMsg == "wrong") {
    $error = " Incorrect password!";
    $showError = true;
  }
  if ($loginMsg == "false") {
    $error = ' Username does not exist! <a href="" data-toggle="modal" data-target="#signupModal"> Try to sign up </a>';
    $showError = true;
  }
  if ($loginMsg == "true") {
    echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
  Welcome <strong>' . $_SESSION["username"] . '</strong> You successfully logged into iForum. You can join discussions now.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
  }
  if ($showError) {
    echo '<div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
  <strong>Error!</strong>' . $error . '
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
  }
}

if (isset($_GET["logout"])) {
  $logoutMsg = $_GET["logout"];

  if($logoutMsg=="true"){
    echo '<div class="alert alert-warning alert-dismissible fade show my-0" role="alert">
    <strong>Success!</strong> You successfully logged out from iForum.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
  }
}
