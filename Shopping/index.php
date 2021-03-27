<?php

    //start session
    session_start();
    require_once('./php/CreateDb.php');
    require_once('./php/component.php');

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
  

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>

    <!--Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.css" 
    integrity="sha512-9iWaz7iMchMkQOKA8K4Qpz6bpQRbhedFJB+MSdmJ5Nf4qIN1+5wOVnzg5BQs/mYH3sKtzY+DOgxiwMz8ZtMCsw==" 
    crossorigin="anonymous" />

    <!--Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <link rel="stylesheet" href="style.css"> 

  <!-- J-Query-->
  <script src="jquery-3.5.1.min.js"></script>

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
    <a class="navbar-brand" href="#">Fashion Fun House</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav m-auto font-rubik">
        <li class="nav-item">
          <a class="nav-link" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">On Sale</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Category</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Category</a>
        </li>
      </ul>
      <form action= "#" class= "font-size-14 font-rale">
      <a href = "#" class = "py-2 rounded-pill color-primary-bg">
      <span class="font-size-16 px-2 text-white"> <i class="fas fa-shopping-cart"></i></span>
      <span class="px-3 py-2 rounded-pill text-dark bg-light">
      <?php

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

<!--request method -->
<?php
$name = "";
$nameErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    $nameErr = "Name is required";
  } else {
    $name = test_input($_POST["name"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
      $nameErr = "Only letters and white space allowed";
    }
  }
}
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
  ?>
<!--Start search -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  Name: <input type="text" name="name" value="<?php echo $name;?>">
  <span class="error">* <?php echo $nameErr;?></span>
  <br><br>
  </form>

<!--start #main-site -->

<div class="container">
<div class="row text-center py-5">
    
    <?php

    $text = "";
    /*
    $result = $database->getData();
    while($row = mysqli_fetch_assoc($result)){
        component($row['product_name'], $row['product_price'], $row['product_image'], $row['id']);
    }
    */
    
    $sql = "SELECT * FROM producttb WHERE product_name LIKE '%$name%'";
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

    

    <!--Bootstrap JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

</body>
</html>