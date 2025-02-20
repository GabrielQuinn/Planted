<?php
    session_start();
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
        <button><img src="" alt="options"></button>
        <img src="" alt="logo">
    </nav>
    <header>
        <h1>
        <?php
         echo$_SESSION["category"];
        ?>
        </h1>
    </header>
    <section>
        <form action="roadmap.php" method="post"> <!-- finish this tmr -->
            <input type="submit" name="introduction" value="Introduction">
            <input type="submit" name="" value="Introduction">
            <input type="submit" name="introduction" value="Introduction">
            <input type="submit" name="introduction" value="Introduction">
            <input type="submit" name="introduction" value="Introduction">
            <input type="submit" name="introduction" value="Introduction">
        </form>
    </section>
</body>
</html>
<?php
?>