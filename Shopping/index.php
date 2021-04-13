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

/*
if ($_SERVER["REQUEST_METHOD"] == "GET") {
if (empty($_GET["name"])) {
  $nameErr = "Name is required";
} else {
  $name = test_input($_GET["name"]);
  // check if name only contains letters and whitespace
  if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
    $nameErr = "Only letters and white space allowed";
  }
}
}
*/
//This checks the Get request for name
if(isset($_GET['name'])){
  $name = test_input($_GET["name"]);
}
//Function that prevents sql injection on input
function test_input($data) {
$data = trim($data);
$data = stripslashes($data);
$data = htmlspecialchars($data);
return $data;
}
//This checks the Get request for brand
if(isset($_GET['brand-select'])){
$brand = $_GET['brand-select'];
}
//This gets the Post request for method of order
if(isset($_POST['order-select'])){
  $order = $_POST['order-select'];
  //price order
  if($order == "High to Low"){
    $order = "DESC";
  }
  if($order == "Low to High"){
    $order = "ASC";
  }
  //alphabetical order
  if($order == "AZ"){
  $AZorder = "ASC";
  }
  if($order == "ZA"){
  $AZorder = "DESC";
  }
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
    <!--Start search -->
    
<form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  
  <div class="input-group">
      <input class="form-control" placeholder="Search for..." type="text" name="name" value="<?php echo $name;?>">
      <span class="input-group-btn">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </span>
    </div>
  </form>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav m-auto ">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Home</a>
        </li>
        <!-- Brand Select -->
        <li class="nav-item">
          <a class="nav-link" href="index.php?brand-select=Samsung#"
          id = "Samsung-submit" type="submit" name="brand-select" value="Samsung">Samsung</a>
        </li>
          <a class="nav-link" href="index.php?brand-select=Apple" 
          id = "Samsung-submit" type="submit" name="brand-select" value="Apple">Apple</a>
          <li class="nav-item">
          <a class="nav-link" href="index.php?brand-select=Microsoft"
          id = "Microsoft-submit" type="submit" name="brand-select" value="Microsoft">Microsoft</a>
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

<!--!start #header -->

<!--start #main-site -->
<!-- Start of filter tab dropdown -->
<div class="dropdown">
  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" 
  data-bs-toggle="dropdown" aria-expanded="false">
    Filters
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
  <form action="" method="post">  
   
   <button class="dropdown-item" id = "ASC-submit" type="submit" name="order-select" value="Low to High">
   Price, Low to High</button>
   <button class="dropdown-item" id = "DESC-submit" type="submit" name="order-select" value="High to Low">
   Price, High to Low</button>
   <button class="dropdown-item" id = "AZ-submit" type="submit" name="order-select" value="AZ">
   Alphabetical, A to Z</button>
   <button class="dropdown-item" id = "ZA-submit" type="submit" name="order-select" value="ZA">
   Alphabetical, Z to A</button>
  </form>
  </ul>
<br><br>
<br>
  
<div class="container">
<div class="row text-center py-5">
    <?php

  //DEFAULT "COMMAND" AS OF NOW
  // THIS COMMAND SHOULD BE REPLACED WITH A MORE "SORTED" LOOK RATHER THAN HOW STUFF IS PLACED IN DB
  $sql = "SELECT * FROM producttb ORDER by brand ASC";

  //SWITCH CASES THAT DETERMINE WHAT FILTERS ARE USED
  if ($name != ""){
    $sql = "SELECT * FROM producttb WHERE product_name LIKE '%$name%'";
  }
  if($brand != ""){
    $sql = "SELECT * FROM producttb WHERE brand LIKE '%$brand%'";
  }
  if($order != ""){
    $sql = "SELECT * FROM producttb ORDER BY product_price $order";
  }
  if($AZorder != ""){
    $sql = "SELECT * FROM producttb ORDER BY product_name $AZorder";
  }
  if($brand != "" && $order != ""){
    $sql = "SELECT * FROM producttb
    WHERE brand Like '%$brand%'
    ORDER by product_price $order";
  }
  if($brand != "" && $AZorder != ""){
    $sql = "SELECT * FROM producttb
    WHERE brand Like '%$brand%'
    ORDER by product_name $AZorder";
  }
  if ($name != "" && $order !=""){
    $sql = "SELECT * FROM producttb WHERE product_name LIKE '%$name%' ORDER by product_price $order";
  }
  if ($name != "" && $AZorder !=""){
    $sql = "SELECT * FROM producttb WHERE product_name LIKE '%$name%' ORDER by product_name $AZorder";
  }
  //PROCESSES THE SQL COMMAND
    $result = mysqli_query($database->con, $sql);
    while($row = mysqli_fetch_assoc($result)){
      component($row['product_name'], $row['product_price'], $row['product_image'], $row['id']);
    }
    
        ?>
    </div>
</div>

<!--start #footer-->
    <footer>

    </footer>
    
</body>
</html>