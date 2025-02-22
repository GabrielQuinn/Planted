<?php
    session_start();

    include("database.php");
    
    if($_SESSION["category"] == "Flowers") {
        $table = "flower_questions";
    } elseif($_SESSION["category"] == "Trees") {
        $table = "tree_questions";
    } elseif($_SESSION["category"] == "Fungi") {
        $table = "fungi_questions";
    } else {
        $table = "climate_change_questions";
    }

    $sql = "SELECT * FROM {$table}";

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

    if (!isset($_SESSION["completed"])) {
        $_SESSION["completed"] = false;
    }

    if(isset($_POST["lesson"])){
        header("Location: lesson.php");
    }
    if(isset($_POST["next"])){
        if($_SESSION["quiz_index"] < 3) {
            $_SESSION["quiz_index"] = $_SESSION["quiz_index"] + 1;
            $_SESSION["completed"] = false;
            header("Location: quiz.php");
        }
    }
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
    <section class="quiz_answer">
        <h1>Category - <?php echo$_SESSION["category"] ?></h1>
        <h2>True or False:</h2>
        <p><?php
            echo$question;
        ?></p>
        <?php
        if((isset($_POST["true"]) || isset($_POST["false"]))){
            if($_SESSION["completed"] == false) {
                $_SESSION["completed"] = true;
                if(($answer == 1 && isset($_POST["true"])) || ($answer == 0 && isset($_POST["false"]))) {
                    // CORRECT!!!!!!!!!!
                    echo"<h3 class='correct'>Correct</h3>";
                }
                else {
                    // INCORRECT!!!!!!!!!!!
                    echo"<h3 class='incorrect'>Incorrect</h3>";
                }
            }
        }
        ?>
        <p>
            <?php 
                if((isset($_POST["true"]) || isset($_POST["false"]))) {
                    echo$solution;
                }
            ?>
        </p>
        <section class="quiz_input">
            <form action="quiz.php" method="post">
                <input type="submit" name="true" value="True"
                <?php 
                    if((isset($_POST["true"]) || isset($_POST["false"]))) {
                        echo' style="display:none"';
                    }
                ?>>
                <input type="submit" name="false" value="False"
                <?php 
                    if((isset($_POST["true"]) || isset($_POST["false"]))) {
                        echo' style="display:none"';
                    }
                ?>>
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