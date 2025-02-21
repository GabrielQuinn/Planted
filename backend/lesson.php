<?php
    session_start();

    include("database.php");
    if($_SESSION["category"] == "Flowers") $sql = "SELECT * FROM flower_lessons";
    if($_SESSION["category"] == "Trees") $sql = "SELECT * FROM tree_lessons";
    if($_SESSION["category"] == "Fungi") $sql = "SELECT * FROM fungi_lessons";
    if($_SESSION["category"] == "Climate Change") $sql = "SELECT * FROM climate_change_lessons";
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

    mysqli_close($conn);
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
        <span>Progress: <?php echo$_SESSION["lesson_index"] + 1 ?>/4</span>
        <form action="lesson.php" method="post">
            <input type="submit" name="lessons" value="View All Lessons">
        </form>
    </nav>
    <section>
        <h1>Category - <?php echo$_SESSION["category"] ?></h1>
        <h2><?php
            echo$title;
        ?></h2>
        <p><?php
            echo$para;
        ?></p>
        <section>
            <form action="lesson.php" method="post">
                <?php
                    if($_SESSION["lesson_index"] > 0) {
                        echo '<input type="submit" name="previous" value="Previous Lesson">';
                    }
                ?>
                <input type="submit" name="quiz" value="Quiz Me">
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
<?php
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
        header("Location: quiz.php");
    }
    if(isset($_POST["home"])){
        header("Location: home.php");
    }
    if(isset($_POST["lessons"])){
        header("Location: roadmap.php");
    }
?>