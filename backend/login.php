<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planted</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <header>
        <h1>Log In</h1>
    </header>
    <section class="login">
        <form action="login.php" method="post">
            <label for="email">Email:</label>
            <input type="email" name="email">
            <label for="password">Password:</label>
            <input type="password" name="password">
            <input type="submit" name="login" value="Log In">
        </form>
        <div>Don't have an account? <a href="signup.php">Click here.</a></div>
    </section>
</body>
</html>
<?php
    if(isset($_POST["login"])){
        if(!empty($_POST["email"]) &&
            !empty($_POST["password"])){
            $_SESSION["email"] = $_POST["email"];
            $_SESSION["password"] = $_POST["password"];

            include("database.php");

            $email = $_POST["email"];
            $password = $_POST["password"];

            $email_found = false;

            // FIND EMAIL AND THEN COMPARE PASSWORDS
            $sql = "SELECT * FROM users WHERE email = '" . $email . "'";
            $result = mysqli_query($conn, $sql);
            $items = [];

            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                    if(password_verify($password, $row["password"])) {
                        $email_found = true;
                        $_SESSION["name"] = $row["name"];
                        break;
                    }
                };
            }
            
            // $email_found = password_verify($password, $row["password"]);

            if($email_found) {
                header("Location: home.php");
            }
            else {
                echo "Could not find account";
            }
        }
        else{
            echo "Missing email/password";
        }
    }
?>