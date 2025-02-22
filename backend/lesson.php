<?php
    session_start();

    include("database.php");
    if($_SESSION["category"] == "Flowers") {
        $table1 = "flower_lessons";
        $table2 = "flowers_complete";
    } elseif($_SESSION["category"] == "Trees") {
        $table1 = "tree_lessons";
        $table2 = "trees_complete";
    } elseif($_SESSION["category"] == "Fungi") {
        $table1 = "fungi_lessons";
        $table2 = "fungi_complete";
    } else {
        $table1 = "climate_change_lessons";
        $table2 = "climate_change_complete";
    }

    $sql = "SELECT * FROM {$table1}";

    $result = mysqli_query($conn, $sql);
    $_SESSION["rows"] = array();

    if (!isset($_SESSION["lesson_index"])) {
        $_SESSION["lesson_index"] = 0;
    }

    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $_SESSION["rows"][] = $row;
        };
    }

    $title = $_SESSION["rows"][$_SESSION["lesson_index"]]["title"];
    $para = $_SESSION["rows"][$_SESSION["lesson_index"]]["para"];

    // checking if they got to the 4th lesson
    if($_SESSION["lesson_index"] == 3) {
        $sql = "UPDATE users SET {$table2} = 1
                    WHERE email = '{$_SESSION['email']}'";

        try{
            mysqli_query($conn, $sql);
        }
        catch(mysqli_sql_exception){
            echo"Could not register";
        }

        $sql = "SELECT * FROM users WHERE email = '" . $_SESSION["email"] . "'";
        $result = mysqli_query($conn, $sql);
        $items = [];

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                $_SESSION["completed_lessons"] = $row["flowers_complete"] + $row["trees_complete"] + $row["fungi_complete"] + $row["climate_change_complete"];
            };
        }
    }

    mysqli_close($conn);

    if(isset($_POST["next"])){
        $_SESSION["lesson_index"] = $_SESSION["lesson_index"] + 1;
        header("Location: lesson.php");
    }
    if(isset($_POST["previous"])){
        $_SESSION["lesson_index"] = $_SESSION["lesson_index"] - 1;
        header("Location: lesson.php");
    }
    if(isset($_POST["quiz"])){
        $_SESSION["quiz_index"] = 0;
        $_SESSION["completed"] = false;
        header("Location: quiz.php");
    }
    if(isset($_POST["home"])){
        header("Location: index.php");
    }
    if(isset($_POST["lessons"])){
        header("Location: roadmap.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lesson</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <nav>
        <form action="lesson.php" method="post">
            <input type="submit" name="home" value="Return to Home">
        </form>
        <span>Progress: <?php echo strval($_SESSION["lesson_index"] + 1) ?>/4</span>
        <form action="lesson.php" method="post">
            <input type="submit" name="lessons" value="View All Lessons">
        </form>
    </nav>
    <section class="lesson">
        <h1>Category - <?php echo$_SESSION["category"] ?></h1>
        <h2><?php
            echo$title;
        ?></h2>
        <p><?php
            echo$para;
        ?></p>
        <section class="lesson_input">
            <form action="lesson.php" method="post">
                <?php
                    if($_SESSION["lesson_index"] > 0) {
                        echo '<input type="submit" name="previous" value="Previous Lesson">';
                    }
                ?>
                <input type="submit" name="quiz" value="Quiz Me" class="quiz_button">
                <?php
                    if($_SESSION["lesson_index"] < 3) {
                        echo '<input type="submit" name="next" value="Next Lesson">';
                    }
                ?>
            </form>
        </section>
    </section>
</body>
</html>