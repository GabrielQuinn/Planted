<?php
    session_start();

    if(isset($_POST["signup"])){
        if(!empty($_POST["name"]) && 
            !empty($_POST["email"]) &&
            !empty($_POST["password"])){
            $_SESSION["name"] = $_POST["name"];
            $_SESSION["email"] = $_POST["email"];
            $_SESSION["password"] = $_POST["password"];
            // validate here
            // check if email is in use

            include("database.php");

            $name = $_POST["name"];
            $email = $_POST["email"];
            $password = $_POST["password"];

            $hash = password_hash($password, PASSWORD_DEFAULT);

            // CHECKING IF EMAIL IS ALREADY IN USE
            $sql = "SELECT * FROM users";
            $result = mysqli_query($conn, $sql);
            $rows = array();

            $email_taken = false;
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                    if($row["email"] == $email) {
                        $email_taken = true;
                        echo "Email is already in use";
                        break;
                    }
                };
            }

            if($email_taken == false) {
                $sql = "INSERT INTO users (name, email, password)
                    VALUES ('{$name}', '{$email}', '{$hash}')";

                $conn = mysqli_connect($db_server,
                $db_user,
                $db_pass,
                $db_name);

                try{
                    mysqli_query($conn, $sql);
                    $_SESSION["completed_lessons"] = 0;
                    header("Location: index.php");
                }
                catch(mysqli_sql_exception){
                    echo"Could not register";
                }
                mysqli_close($conn);
            }
        }
        else{
            echo "Missing username/email/password";
        }
    }
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
        <h1>Sign Up</h1>
    </header>
    <section class="signup">
        <form action="signup.php" method="post">
            <label for="name">Name:</label>
            <input type="text" name="name">
            <br>
            <label for="email">Email:</label>
            <input type="email" name="email">
            <br>
            <label for="password">Password:</label>
            <input type="password" name="password">
            <br>
            <input type="submit" name="signup" value="Sign Up">
        </form>
        <div>Already have an account? <a href="login.php">Click here.</a></div>
    </section>
</body>
</html>