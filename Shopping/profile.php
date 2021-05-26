<?php
//Brandon Cossin
// For Intro to Database Class Spring 2021
session_start();
require_once('./includes/functions.inc.php');
require_once('./includes/dbh.inc.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech Fun House</title>

  <!-- J-Query-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="jquery-3.5.1.min.js"></script>
  
  <!--Bootstrap-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
<!-- start #header -->
<header>
  <!--
    <div class="strip d-flex justify-content-between px-4 py-1 bg-light">
    <P class= "font-size-20 text-black-50 m-0"> Project Created For Intro-To-Database-Design </p>
    </div>
-->
    <!--start #nav-bar -->

    <nav class="navbar navbar-expand-lg navbar-dark color-second-bg">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Tech Fun House</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav m-auto ">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="signup.php"></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="signup.php"></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="signup.php"></a>
        </li>
        <?php
          if(isset($_SESSION["accountUsername"])){
            $accountUsername = $_SESSION["accountUsername"];
            echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"profile.php\">$accountUsername</a></li>";
            echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"logout.php\">Log out</a></li>";
          }
          else{
            echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"signup.php\">Sign up</a></li>";
            echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"login.php\">Log in</a></li>";
          }

        ?>
        
  </form>
      </ul>
      
    </div>
  </div>
</nav>
    </header>
<!--start of main-->
<div class="col d-flex justify-content-center">
<div class="card" style="width: 35rem;">
  <div class="card-body">
  <?php 
  $accountUsername = $_SESSION["accountUsername"];
  $accountWallet = $_SESSION["accountWallet"];
  $accountid = $_SESSION["accountID"];
  echo "<h5 class=\"card-title\">Welcome $accountUsername</h5>";
  echo "<h6 class=\"card-subtitle mb-2 text-muted\">Your account has $$accountWallet</h6>";
  if(isset($_POST['button1'])){
    updateWallet100($conn, $accountUsername);
  }
if(isset($_POST['button2'])){
  deleteAccount($conn, $accountUsername);
}
if(isset($_POST['button3'])){
  clearCart($conn, $accountid);
  
}
  ?>
   <form method="post">
  <div class="row align-items-start">
  <br>
  <!--PHP profile functions -->
    <div class="col">
    <button type="submit" class="btn btn-primary" name="button1" >
      Add $100
    </button>
    </div>
    <div class="col">
    <button type="submit" class="btn btn-danger" name="button2">
     Delete account
     </button>
    </div>
    <div class="col">
    <button type="submit" class="btn btn-danger" name="button3">
     Clear Cart
     </button>
    </div>
  </div>
  </form>
  <br>
  <?php 
  echo "<hr><h5 class=\"card-title\">Cart</h5>";
  $accountUsername = $_SESSION["accountUsername"];
  $accountid = $_SESSION["accountID"];
  viewCart($conn, $accountid);
  ?>
  <hr>
  Order Summary: <?php
  $accountid = $_SESSION["accountID"];
  sumCart($conn, $accountid);
?>
    </div>
    </div>
</div>

</body>
</html>