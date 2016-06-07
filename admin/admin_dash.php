<html>
<head>
    <title>PrognosiX</title>
    <link rel="stylesheet" type="text/css" href="../CSS/style.css">
    <script type="text/javascript" src="../JS/functions.js"></script>
</head>

<?php

include("../user/session.php");

$servername = "localhost";
$username = "serb_costa";
$pass = "pass";
$DB = "TW_database";
$conn = new mysqli($servername, $username, $pass, $DB);

if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);

}

$matricola_student = $_SESSION['nr_matricol'];

$sql_info_student = "SELECT nume, prenume, grupa,email,matricola from studenti where matricola = ?";

$student_info_query = $conn->prepare($sql_info_student);
$student_info_query->bind_param("s", $matricola_student);
$student_info_query->execute();
$student_info_query->bind_result($nume, $prenume, $grupa, $email, $matricola);
$student_info_query->fetch();

?>

<body>

<header class="main_header">
    <a href=  <?php if($_SESSION['admin']==0) echo "admin_dash.php"  ?>   >
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

        <button>
            <li class="left_menu_item" id="catalog_profil_switch" onclick="admin_trigger_middle_Functions()">Actiuni
                admin
            </li>
        </button>
        <button>
            <li class="left_menu_item"><a href="../user/change_pass.php">Schimba parola </a></li>
        </button>
        <button>
            <li class="left_menu_item"><a href="download_stats.php"> Statistici </a></li>
        </button><br>
        <button>
            <li class="left_menu_item"><a href="../user/logout.php"> Log out </a></li>
        </button>


    </ul>

</div>
<div class="middle_section">

    <div id="info_student">

        <ul class="student_informations_list">

            <li>Nume: <?php echo ucfirst($nume) ?></li>
            <li>Prenume: <?php echo ucfirst($prenume) ?></li>
            <li>E-mail: <?php echo $email ?></li>

        </ul>

    </div>

</div>


</body>

</html>