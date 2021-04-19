<?php
//Function that prevents sql injection on input
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
    }

function emptyInputSignup($name, $email, $username, $pwd, $pwdRepeat){
   $result;
   if(empty($name) || empty($email) || empty($username) || empty($pwd)|| empty($pwdRepeat)){
    $result = true;
   }
   else{
       $result = false;
   }
   return $result;
}
function emptyInputLogin($username, $pwd){
    $result;
    if(empty($username) || empty($pwd)){
     $result = true;
    }
    else{
        $result = false;
    }
    return $result;
 }
function uidExists($conn, $username){
    $sql = "SELECT * FROM account WHERE accountUsername = ?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    if($row = mysqli_fetch_assoc($resultData)){
        return $row;
    }
    else{
        $result = false;
        return $result;
    }
}
function createUser($conn, $name, $email, $username, $pwd){
    $sql = "INSERT INTO account(accountID, accountName, accountEmail, accountUsername, accountPassword, accountWallet) VALUES (NULL, ?, ?, ?, ?, 0);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $username, $pwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../signup.php?error=none");
    exit();
}
function loginUser($conn, $username, $pwd){
    $uidExists = uidExists($conn, $username);
    if($uidExists === false){
        header("location: ../login.php?error=wronglogin");
        exit();
    }
    $checkPwd = $uidExists["accountPassword"];
    if($checkPwd != $pwd){
        header("location: ../login.php?error=wronglogin");
        exit();
    }
    if($checkPwd == $pwd){
        session_start();
        $_SESSION["accountID"] = $uidExists["accountID"];
        $_SESSION["accountUsername"] = $uidExists["accountUsername"];
        $_SESSION["accountName"] = $uidExists["accountName"];
        $_SESSION["accountWallet"] = $uidExists["accountWallet"];
        header("location: ../index.php");
        exit();
    }
}
function component($productname, $productprice, $productimg, $productid ){
    $element = "
    <div class=\"col-md-3 col-sm-6 my-3 my-md-0\">
        <form action=\"index.php\" method=\"post\">
        <div class=\"card shadow\">
        <div>
        <img src=\"$productimg\" class= \"img-fluid card-img-top\" style=\"height:400px;\">
        </div>
        <div class= \"card-body\">
        <h5 class=\"card-title\">$productname</h5>
        <h5>
            <span class=\"price\">$$productprice</span>
        </h5>

    <button type=\"submit\" class=\"btn btn-warning my-3\" name=\"add\"> Add to Cart<i class=\"fas fa=shopping-cart\"></i></button>
    <input type='hidden' name='product_id' value='$productid'>
    <input type='hidden' name='product_price' value='$productprice'>
        </div>
        </div>
        </form>
    </div>
    ";
    echo $element;
}
function addToCart($conn, $accountID, $productid, $productprice){
    /*
    $sql = "INSERT INTO cart(accountID, id, product_price) VALUES (?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_bind_param($stmt, "iii", $accountID, $productid, $productprice);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    exit();
    */
    $sql = "INSERT INTO cart(accountID, id, product_price) VALUES ($accountID, $productid, $productprice);";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_execute($stmt);
    exit();
}
function updateWallet100($conn, $accountUsername){
    $uidExists = uidExists($conn, $accountUsername);
    $sql = "Update account SET accountWallet = accountWallet + 100 WHERE accountUsername = $accountUsername;";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_execute($stmt);
    //Refreshes Session variable after Update
    $_SESSION["accountWallet"] = $uidExists["accountWallet"];
    exit();
}
