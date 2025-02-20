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
    <nav>
        <button><img src="" alt="options"></button>
        <img src="" alt="logo">
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
            echo "<ul><li>Streak: {1}</li><li>Average: {100}</li></ul>";
        }
        else{
            echo"<h1>Welcome to Planted!</h1>";
        }
        ?>
    </header>
    <section> <!-- CATEGORIES -->
        <div class="container">
            <h3>Learning</h3>
            <form action="home.php" method="post" class="grid" id="grid1">
                <input type="submit" name="flowers" value="Flowers" class="item item1">
                <input type="submit" name="trees" value="Trees" class="item item2">
                <input type="submit" name="fungi" value="Fungi" class="item item3">
                <input type="submit" name="climate_change" value="Climate Change" class="item item4">
                <input type="submit" name="categories" value="All Categories" class="item item5">
            </form>
        </div>
    </section>
    <section> <!-- FUN FACTS -->
        <h3>Fun Fact</h3>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsum repellat obcaecati provident impedit numquam nam velit, deserunt, tempore earum, asperiores quibusdam temporibus fugit amet aliquam nostrum eius. Quaerat, unde similique.</p>
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