<?php
    session_start();

    include("database.php");
    $sql = "SELECT * FROM fun_facts";
    $result = mysqli_query($conn, $sql);
    $rows = array();

    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $rows[] = $row;
        };
    }

    $fun_fact = $rows[rand(0, count($rows) - 1)]["text"];
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
            <img src="../img/logo.png" alt="Logo">
        </span>
        <form action="home.php" method="post" 
        <?php
            if(isset($_SESSION["name"])) {
                echo' display="none"';
            }
        ?>
        >
            <input type="submit" name="logout" value="Logout">
        </form>
    </nav>
    <header>
        <?php
        if(isset($_SESSION["name"])){
            echo "<h1>Hello, ".$_SESSION["name"]."!</h1>";
            echo "<ul class='score_mobile'><li>Lessons Completed:</li><li>0/4</li></ul>";
        }
        else{
            echo"<h1>Welcome to Planted!</h1>";
        }
        ?>
    </header>
    <section class="main"> <!-- CATEGORIES -->
        <div class="container">
            <form action="home.php" method="post" class="grid" id="grid1">
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
                <h4>0/4</h4>
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
<?php
    if(isset($_POST["flowers"]) || isset($_POST["trees"]) || isset($_POST["fungi"]) || isset($_POST["climate_change"])){
        // this part is bad
        if(isset($_POST["flowers"])) {
            $category = "Flowers";
        } elseif(isset($_POST["trees"])) {
            $category = "Trees";
        } elseif(isset($_POST["fungi"])) {
            $category = "Fungi";
        } else{
            $category = "Climate Change";
        }

        //$_SESSION["index"] = 0;
        $_SESSION["category"] = $category;
        
        header("Location: lesson.php");
    }
    if(isset($_POST["logout"])) {
        session_destroy();
        header("Location: signup.php");
    }
?>