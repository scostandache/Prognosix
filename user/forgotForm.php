<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lost password</title>
    <link rel="stylesheet" type="text/css" href="../CSS/style.css">
</head>
<body>
    <header class="main_header">
        <a href="home.php">
            <div class="logo">
                <div class="app_name">ProGnosiX</div>
                <div class="slogan">Guess Your Mark</div>
            </div>
        </a>
        <div id="actual_section">
            Lost password
        </div>

    </header>
    <form action="forgot.php" method="post">

        Numarul matricol:
        <input type="text" name="matricola"><br>

        Intrebare secreta:
        <input type="text" name="intrebare"><br>
        Raspuns:
        <input type="text" name="raspuns"><br>

        <input type="submit" value="Send" name="submit2">
    </form>
</body>
</html>