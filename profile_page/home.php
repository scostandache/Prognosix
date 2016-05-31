<html>
<head>
    <title>PrognosiX</title>
    <link rel="stylesheet" type="text/css" href="../CSS/style.css">
    <script type="text/javascript" src="..//JS/functions.js"></script>
</head>

<?php


    include("../user/session.php");

    $servername="localhost";
    $username="serb_costa";
    $pass="pass";
    $DB="TW_database";
    $conn= new mysqli($servername,$username,$pass,$DB);

    if ($conn->connect_error) {

        die("Connection failed: " . $conn->connect_error);

    }

    $matricola_student=$_SESSION['nr_matricol'];

    $sql_info_student="SELECT nume, prenume, grupa,email,matricola from studenti where matricola = ?";

    $student_info_query=$conn->prepare($sql_info_student);
    $student_info_query->bind_param("s",$matricola_student );
    $student_info_query->execute();
    $student_info_query->bind_result($nume,$prenume,$grupa,$email,$matricola);
    $student_info_query->fetch();
    
    
?>

<body>

    <header class="main_header">
        <a href="home.php">
            <div class="logo">
                    <div class="app_name">ProGnosiX</div>
                    <div class="slogan">Guess Your Mark</div>
            </div>
        </a>
        <div id="actual_section">
            Profilul meu
        </div>

    </header>

    <div class="left_section">

        <ul class="left_menu">

            <li class="left_menu_item" id="catalog_profil_switch" onclick="trigger_middle_Functions()">Catalog Note</li>
            <li class="left_menu_item"><a href="change_pass.php">Schimba parola </a> </li>
            <li class="left_menu_item"><a href="../user/logout.php"> Log out </a> </li>

        </ul>

    </div>

    <div class="middle_section">

        <div id="info_student">

              <ul class="student_informations_list">

                  <li>Nume: <?php echo ucfirst($nume) ?></li>
                  <li>Prenume: <?php echo ucfirst($prenume) ?></li>
                  <li>Grupa: <?php echo $grupa ?></li>
                  <li>E-mail: <?php echo $email ?></li>
                  <li>Nr. matricol: <?php echo $matricola ?></li>

              </ul>

        </div>

        <div class="atom_feed"></div>

    </div>

    <div class="right_section">

        <?php include('guess_grades.php');?>

    </div>

</body>

</html>

