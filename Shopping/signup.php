<?php
//Brandon Cossin
// For Intro to Database Class Spring 2021

//start session
session_start();
require_once('./php/CreateDb.php');
require_once('./php/component.php');
$name = "";
$nameErr = "";
$brand = "";
$order = "";
$AZorder = "";

//create instance of Createdb class
$database = new CreateDb("Productdb", "Producttb");
if (isset($_POST['add'])){
  /// print_r($_POST['product_id']);
  if(isset($_SESSION['cart'])){

      $item_array_id = array_column($_SESSION['cart'], "product_id");

      if(in_array($_POST['product_id'], $item_array_id)){
          echo "<script>alert('Product is already added in the cart..!')</script>";
          echo "<script>window.location = 'index.php'</script>";
      }else{

          $count = count($_SESSION['cart']);
          $item_array = array(
              'product_id' => $_POST['product_id']
          );

          $_SESSION['cart'][$count] = $item_array;
      }

  }else{

      $item_array = array(
              'product_id' => $_POST['product_id']
      );

      // Create new session variable
      $_SESSION['cart'][0] = $item_array;
      print_r($_SESSION['cart']);
  }
}



//Function that prevents sql injection on input
function test_input($data) {
$data = trim($data);
$data = stripslashes($data);
$data = htmlspecialchars($data);
return $data;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech Fun House</title>

    <!--Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.css" 
    integrity="sha512-9iWaz7iMchMkQOKA8K4Qpz6bpQRbhedFJB+MSdmJ5Nf4qIN1+5wOVnzg5BQs/mYH3sKtzY+DOgxiwMz8ZtMCsw==" 
    crossorigin="anonymous" />

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
  <!--This helps the page reset variables -->
  <script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
        unset($_GET['brand-select']);
    }
    
</script>
</head>
<body>
<!-- start #header -->
<header>
    <div class="strip d-flex justify-content-between px-4 py-1 bg-light">
    <P class= "font-size-20 text-black-50 m-0"> Project Created For Intro-To-Database-Design </p>
    <div class="font-size-14">
    <a href = "#" class="px-3 border-right border-left text-dark">Login</a>
    <a href = "#" class="px-3 border-right text-dark">Wishlist(0)</a>
    </div>
    </div>
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
        <li class="nav-item">
          <a class="nav-link" href="signup.php">Sign up</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="login.php">Log in</a>
        </li>
  </form>
      </ul>
      <form action= "#" class= "font-size-14 font-rale">
      <a href = "#" class = "py-2 rounded-pill color-primary-bg">
      <span class="font-size-16 px-2 text-white"> <i class="fas fa-shopping-cart"></i></span>
      <span class="px-3 py-2 rounded-pill text-dark bg-light">
      <?php
//CART "SESSION" THAT COUNTS HOW MANY ITEMS IN USERS ACCOUNT 
//WORK IN PROGRESS, VERY LATE PROJECT IDEA     
if(isset($_SESSION['cart'])){
  $count = count($_SESSION['cart']);
  echo "<span id=\"cart_count\" class=\"text-warning bg-light\">$count</span>";
}else{
  echo "<span id=\"cart_count\" class=\"text-warning bg-light\">0</span>";

}
?>
</span>
</a>
</form>
    </div>
  </div>
</nav>
    </header>
</body>

<!--start of main-->
<div class="col d-flex justify-content-center">
<div class="card" style="width: 35rem;">
  <div class="card-body">
    <h5 class="card-title">Sign Up</h5>
    <h6 class="card-subtitle mb-2 text-muted">Create your account. It's free and only takes a minute.</h6>
    <ul class="list-group list-group-flush">
    <form action= "includes/signup.inc.php" method="post"> 
    <div class="row">
    <li class="list-group-item"><input type="text" name="name" placeholder="Name..."></li>
</div>
    <div class="row">
    <li class="list-group-item"><input type="text" name="email" placeholder="Email..."></li>
</div>
<div class="row">
    <li class="list-group-item"><input type="text" name="uid" placeholder="Username..."></li>
</div>
    <div class="row">
    <li class="list-group-item">
    <input type="password" name="pwd" placeholder="Password...">
    <input type="password" name="pwdrepeat" placeholder="Repeat Password..."></li>
</div>
    <div class="row">
    <div class="col-4">
        <button type="submit" name="submit">Sign Up</button>
</div>
    </div>
</form>
  </ul>
  </div>
</div>


</html>