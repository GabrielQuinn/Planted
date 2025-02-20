<?php
    session_start();

    include("database.php");
    $sql = "SELECT * FROM flower_questions";
    $result = mysqli_query($conn, $sql);
    $rows = array();

    if (!isset($_SESSION["quiz_index"]) || $_SESSION["quiz_index"] > 3) {
        $_SESSION["quiz_index"] = 0;
    }
    if (!isset($_SESSION["lesson_index"])) {
        $_SESSION["lesson_index"] = 0;
    }

    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            if($row["category"] == $_SESSION["lesson_index"] + 1) {
                $rows[] = $row;
            }
        };
    }

    $question = $rows[$_SESSION["quiz_index"]]["question"];
    $answer = $rows[$_SESSION["quiz_index"]]["answer"];
    $solution = $rows[$_SESSION["quiz_index"]]["solution"];

    mysqli_close($conn);

    $completed = false;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <nav>
        <form action="quiz.php" method="post">
            <input type="submit" name="lesson" value="Return to Lesson">
        </form>
        <span>Progress: <?php echo$_SESSION["quiz_index"] + 1 ?>/4</span>
        <form action="lesson.php" method="post">
            <input type="submit" name="questions" value="View All Questions">
        </form>
    </nav>
    <section>
        <h1>Category - <?php echo$_SESSION["category"] ?></h1>
        <h2>True or False:</h2>
        <p><?php
            echo$question;
        ?></p>
        <p>
            <?php 
                if((isset($_POST["true"]) || isset($_POST["false"]))) {
                    echo$solution;
                }
            ?>
        </p>
        <section>
            <form action="quiz.php" method="post">
                <input type="submit" name="true" value="True">
                <input type="submit" name="false" value="False">
                <?php 
                    if((isset($_POST["true"]) || isset($_POST["false"])) && $_SESSION["quiz_index"] < 3) {
                        echo'<input type="submit" name="next" value="Next Question">';
                    }
                ?>
            </form>
        </section>
    </section>
</body>
</html>
<?php
    if(isset($_POST["true"]) || isset($_POST["true"]) && $completed == false){
        $completed = true;
        if(($answer == 1 && isset($_POST["true"])) || ($answer == 0 && isset($_POST["false"]))) {
            // CORRECT!!!!!!!!!!
            echo"CORRECT";
        }
        else {
            // INCORRECT!!!!!!!!!!!
            echo"INCORRECT";
        }
    }
    if(isset($_POST["lesson"])){
        header("Location: lesson.php");
    }
    if(isset($_POST["next"])){
        if($_SESSION["quiz_index"] < 3) {
            $_SESSION["quiz_index"] = $_SESSION["quiz_index"] + 1;
            header("Location: quiz.php");
        }
    }
?>