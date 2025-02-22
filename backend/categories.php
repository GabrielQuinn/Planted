<?php
    session_start();
    include("database.php");

    // fetching fun facts
    $sql = "SELECT * FROM fun_facts";
    $result = mysqli_query($conn, $sql);
    $rows = array();
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $rows[] = $row;
        };
    }
    $fun_fact = $rows[rand(0, count($rows) - 1)]["text"];

    // resetting the lesson number
    $_SESSION["lesson_index"] = 0;

    if(isset($_POST["flowers"]) || isset($_POST["trees"]) || isset($_POST["fungi"]) || isset($_POST["climate_change"])){
        // this part is bad
        if(isset($_POST["flowers"])) {
            $_SESSION["category"] = "Flowers";
        } elseif(isset($_POST["trees"])) {
            $_SESSION["category"] = "Trees";
        } elseif(isset($_POST["fungi"])) {
            $_SESSION["category"] = "Fungi";
        } else{
            $_SESSION["category"] = "Climate Change";
        }
        
        header("Location: lesson.php");
    }

    // page buttons
    if(isset($_POST["logout"])) {
        session_destroy();
        header("Location: signup.php");
    }
    if(isset($_POST["home"])) {
        header("Location: index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planted</title>
    <link rel="stylesheet" href="main.css?v=<?php echo time(); ?>">
</head>
<body>
    <nav>
        <span>
            <h2>Planted</h2>
            <img src="img/logo.png" alt="Logo">
        </span>
        <form action="categories.php" method="post" 
        <?php
            if(isset($_SESSION["name"])) {
                echo' display="none"';
            }
        ?>
        >
            <input type="submit" name="logout" value="Logout">
        </form>
    </nav>
    <section class="categories"> <!-- CATEGORIES -->
        <div class="container">
            <form action="categories.php" method="post" class="grid" id="grid2">
                <input type="submit" name="flowers" value="Flowers" class="item item1">
                <input type="submit" name="trees" value="Trees" class="item item2">
                <input type="submit" name="fungi" value="Fungi" class="item item3">
                <input type="submit" name="climate_change" value="Climate Change" class="item item4">
                <input type="submit" name="home" value="Return Home" class="item item5">
            </form>
        </div>
    </section>
</body>
</html>