<!DOCTYPE html>
<html>
<head>
    <title>PrognosiX</title>
    <link rel="stylesheet" type="text/css" href="../CSS/style.css">
</head>

<?php

    session_start();
    $_SESSION['matricola']='12sl12';

    $servername="localhost";
    $username="serb_costa";
    $pass="pass";

    $conn= new mysqli($servername,$username,$pass);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo "Connected successfully";

?>



<body>

    <header class="main_header">
        <div class="logo">
                <div class="app_name">ProGnosiX</div>
                <div class="slogan">Guess Your Mark</div>
        </div>

        <div class="actual_section">
            <?php echo "hello"?>
        </div>

    </header>

    <div class="left_section">

        <ul class="left_menu">

            <li class="left_menu_item" onclick="afiseaza_catalog(<?php lista_note ?>)">Catalog Note</li>
            <li class="left_menu_item"><a href="change_pass.php">Schimba parola</a></li>
            <li class="left_menu_item"><a href="logout.php" Log out </a> </li>

        </ul>

    </div>

    <div class="middle_section">


        <div class="info_student">





        </div>

        <div class="atom_feed"></div>



    </div>

    <div class="right_section">


    </div>

</body>





</html>

