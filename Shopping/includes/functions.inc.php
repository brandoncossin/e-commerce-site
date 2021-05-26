<?php
//Function that prevents sql injection on input
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
    }

function uidExists($conn, $username){
    $sql = "SELECT * FROM account WHERE accountUsername = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=statementfailed");
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
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=statementfailed");
        exit();
      }
    mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $username, $pwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../Shopping/index.php");
    $_SESSION['create_msg'] = "Account successfully created";
    exit();
}
function userLogin($conn, $accountUsername, $accountPwd){
    $uidExists = uidExists($conn, $accountUsername);
    $checkPwd = $uidExists["accountPassword"];
    if($checkPwd != $accountPwd){
        header("location: ../Shopping/login.php");
        $_SESSION['login_error_msg'] = "Sorry, that user name or password is incorrect. Please try again.";
        exit();
    }
    if($checkPwd == $accountPwd){
        session_start();
        $_SESSION["accountID"] = $uidExists["accountID"];
        $_SESSION["accountUsername"] = $uidExists["accountUsername"];
        $_SESSION["accountName"] = $uidExists["accountName"];
        $_SESSION["accountWallet"] = $uidExists["accountWallet"];
        header("location: ../Shopping/index.php");
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
    $sql = "INSERT INTO cart(accountID, id, product_price, quantity) VALUES ($accountID, $productid, 0, 0);";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_execute($stmt);
    $sql = "UPDATE cart 
    SET quantity = quantity + 1, product_price = product_price + \"$productprice\"
    WHERE accountID = \"$accountID\" AND id = \"$productid\";";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_execute($stmt);
    $referer = $_SERVER['HTTP_REFERER'];
    header("Location: $referer");
    $_SESSION["cartValue"] = true;
    exit();
}
function updateWallet100($conn, $accountUsername){
    $uidExists = uidExists($conn, $accountUsername);
    $sql = "UPDATE account SET accountWallet = accountWallet + 100 WHERE accountUsername = \"$accountUsername\";";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_execute($stmt);
    //Refreshes Session variable after Update
    //UID row needs to be remade since it just had an action done on it
    $uidExists = uidExists($conn, $accountUsername);
    $_SESSION["accountWallet"] = $uidExists["accountWallet"];
    header("location: ../Shopping/profile.php");
    exit();
}
function clearCart($conn, $accountid){
    $sql = "DELETE FROM cart WHERE accountID = \"$accountid\";";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_execute($stmt); 
    header("location: ../Shopping/profile.php");
    $_SESSION["cartValue"] = false;
}
function deleteAccount($conn, $accountUsername){
    //This function runs the sql command that deletes the user from DB
    //User can not be deleted if parent/foreign key exists in other table
    //This function must reference a secondary function that clears cart
    $uidExists = uidExists($conn, $accountUsername);
    $accountid = $uidExists["accountID"];
    clearCart($conn, $accountid);
    $sql = "DELETE FROM account WHERE accountUsername = \"$accountUsername\";";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_execute($stmt);
    //This part is copied from logout.php and logs out to refresh the session
    session_start();
    session_destroy();
    header("location: ../Shopping/index.php"); 
    exit();
}
function viewCart($conn, $accountid){
    //This is an INNER JOIN to View the Cart
    $sql = "SELECT producttb.product_name, producttb.product_price, cart.product_price, cart.quantity
    FROM cart INNER JOIN producttb ON producttb.id = cart.id AND cart.accountID = \"$accountid\";";
    $result = mysqli_query($conn, $sql); 
    //starts cart table
    if(!$_SESSION["cartValue"]){
        echo "Your cart is empty.";
    }
    else{
    //rows are used over array since poor naming convention
    //i.e. pricing is duplicate named which makes it tricky to find it in an array
    echo "<table>
    <tr>
    <th> Product </th>
    <th>&nbsp Each </th>
    &nbsp
    <th>&nbsp&nbsp Quantity </th>
    <th>&nbsp&nbsp Total </th>
    </tr>";
    while ($row = mysqli_fetch_row($result)) {
        echo "<tr><td>" . $row[0] . "&nbsp&nbsp</td><td>$" . $row[1] . 
        "</td><td>&nbsp&nbsp&nbsp" . $row[3] . "</td><td>&nbsp&nbsp&nbsp$" . $row[2] . "</td></tr>";
    }
    echo "</table>";
}
}
function sumCart($conn, $accountid){
    if($_SESSION["cartValue"]){
    $sql = "SELECT  (
        SELECT SUM(quantity) FROM cart WHERE cart.accountID = \"$accountid\") AS total_count,
        (SELECT SUM(product_price) FROM cart WHERE cart.accountID = \"$accountid\") AS total_cost FROM cart";
    $result = mysqli_query($conn, $sql); 
    //starts cart table
    $row = mysqli_fetch_assoc($result);
    echo "Subtotal (" . $row["total_count"] . " items) &nbsp&nbsp$" . $row["total_cost"];
    }
    else{
        echo "Subtotal (0 items) &nbsp&nbsp$0";
    }
}
