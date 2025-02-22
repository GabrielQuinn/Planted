<?php
    session_start();

    if(isset($_POST["lesson"])){
        header("Location: lesson.php");
    }
    if(isset($_POST["item1"]) || isset($_POST["item2"]) || isset($_POST["item3"]) || isset($_POST["item4"])){
        if (isset($_POST["item1"])) $_SESSION["lesson_index"] = 0;
        if (isset($_POST["item2"])) $_SESSION["lesson_index"] = 1;
        if (isset($_POST["item3"])) $_SESSION["lesson_index"] = 2;
        if (isset($_POST["item4"])) $_SESSION["lesson_index"] = 3;
        //$_SESSION["category"] = explode("m", );
        // SPLIT NAME TO JUST THE NUMBER (use explode())
        header("Location: lesson.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roadmap</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <nav>
        <form action="roadmap.php" method="post">
            <input type="submit" name="lesson" value="Return to Lesson">
        </form>
        <span>
            <h2>Planted</h2>
            <img src="img/logo.png" alt="Logo">
        </span>
    </nav>
    <header>
        <h1>
        <?php
         echo$_SESSION["category"];
        ?>
        </h1>
    </header>
    <section>
        <form action="roadmap.php" method="post" class="roadmap">
            <input type="submit" name="item1" value="<?php echo$_SESSION["rows"][0]["title"]?>" class="roadmap_item item1">
            <div class="line"></div>
            <input type="submit" name="item2" value="<?php echo$_SESSION["rows"][1]["title"]?>" class="roadmap_item item2">
            <div class="line"></div>
            <input type="submit" name="item3" value="<?php echo$_SESSION["rows"][2]["title"]?>" class="roadmap_item item3">
            <div class="line"></div>
            <input type="submit" name="item4" value="<?php echo$_SESSION["rows"][3]["title"]?>" class="roadmap_item item4">
        </form>
    </section>
</body>
</html>