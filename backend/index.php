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
        if(isset($_SESSION["name"])){header("Location: lesson.php");}else header("Location: signup.php");
    }

    // page buttons
    if(isset($_POST["logout"])) {
        session_destroy();
        header("Location: signup.php");
    }
    if(isset($_POST["categories"])) {
        if(isset($_SESSION["name"])){header("Location: categories.php");}else header("Location: signup.php");
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
    <nav class="home_nav">
        <span>
            <h2>Planted</h2>
            <img src="img/logo.png" alt="Logo">
        </span>
        <form action="index.php" method="post"
        <?php
            if(isset($_SESSION["name"])) {
                echo' display="none"';
            }
        ?>
        >
            <input type="submit" name="logout" id="logout" value='<?php if(isset($_SESSION["name"])){echo"Log Out";}else echo"Log In"; ?>'>
        </form>
    </nav>
    <header>
        <?php
        if(isset($_SESSION["name"])){
            echo "<h1>Hello, ".$_SESSION["name"]."!</h1>";
            echo "<ul class='score_mobile'><li>Lessons Completed:</li><li>{$_SESSION['completed_lessons']}/4</li></ul>";
        }
        else{
            echo"<h1>Welcome to Planted!</h1>";
        }
        ?>
    </header>
    <section class="main"> <!-- CATEGORIES -->
        <div class="container">
            <form action="index.php" method="post" class="grid" id="grid1">
                <input type="submit" name="flowers" value="Flowers" class="item item1">
                <input type="submit" name="trees" value="Trees" class="item item2">
                <input type="submit" name="fungi" value="Fungi" class="item item3">
                <input type="submit" name="climate_change" value="Climate Change" class="item item4">
                <input type="submit" name="categories" value="All Categories" class="item item5">
            </form>
        </div>
        <div class="score_desktop">
            <section class="info">
                <h3>Completed Lessons</h3>
                <h4><?php if(isset($_SESSION["completed_lessons"])) {echo$_SESSION['completed_lessons']."/4";} else echo"0/4" ?></h4>
            </section>
            <section class="fun_fact"> <!-- FUN FACTS -->
            <h3>Fun Fact</h3>
                <p><?php echo$fun_fact?></p>
            </section>
        </div>
    </section>
    <section class="fun_fact fun_fact_mobile"> <!-- FUN FACTS -->
        <h3>Fun Fact</h3>
        <p><?php echo$fun_fact?></p>
    </section>
    <footer>
        <ul>
            <li>Website created by Gabriel Quinn</li>
            <li>Art & Design created by Annika Quinn</li>
        </ul>
    </footer>
</body>
</html>