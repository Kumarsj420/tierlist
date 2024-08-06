<?php
$title = "Login to admin panel";

include("header.php");
?>

<div class="login-container">
    <form method="post" enctype="multipart/form-data" class="login-form">
        <div class="input-group">
            <label for="username">Email:</label>
            <input type="email" id="username" name="username" placeholder="Enter email" required="">
        </div>
        <div class="input-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter password" required="">
        </div>
        <div class="form-bottom">
            <button type="submit" name="login">Login</button>
        </div>
    </form>
</div>


<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


if (isset($_POST['login'])) {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        
        $query = "SELECT * FROM admin WHERE email='$_POST[username]'";
        $data = mysqli_query($conn, $query);
        $result = mysqli_fetch_assoc($data);

        $valid_username = $result['email'];
        $valid_password = $result['password'];
        
        $entered_username = $result['email'];
        $entered_password = $_POST['password'];

        if ($entered_username === $valid_username && $entered_password === $valid_password) {
            $_SESSION['admin-email'] = $entered_username;

            echo "Successfully logged in.";
            echo "<script>window.location.href='/backdoor/';</script>";
            exit();
        } else {
            echo "Invalid username or password.";
        }
    } else {
        echo "Please enter both username and password.";
    }
}
?>