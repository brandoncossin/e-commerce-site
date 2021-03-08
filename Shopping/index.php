<?php
    require_once('./php/CreateDb.php');
    require_once('./php/component.php');

    //create instance of Createdb class
    $database = new CreateDb("Productdb", "Producttb");

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


</head>
<body>

<!-- start #header -->
    <header>
    <div class="strip d-flex justify-content-between px-4 py-1 bg-light">
    <P class= "font-size-20 text-black-50 m-0"> Project Created For Intro-To-Database-Design </p>
    </div>
    </header>

<!--!start #header -->

<!--start #main-site -->
<div class="container">
    <div class="row text-center py-5">
    <?php
    $result = $database->getData();
    while($row = mysqli_fetch_assoc($result)){
        component($row['product_name'], $row['product_price'], $row['product_image']);
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