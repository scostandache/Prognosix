<!DOCTYPE HTML>
<html>
<head>
    <style>
        .form{
           width:25%;
            margin:0 auto;

        }
    </style>
    <title>PrognosiX - register</title>
    <link rel="stylesheet" type="text/css" href="../CSS/style.css">
    <script type="text/javascript" src="..//JS/functions.js"></script>

</head>
<body>

<header class="main_header">
    <a href="../index.php">
        <div class="logo">
            <div class="app_name">ProGnosiX</div>
            <div class="slogan">Guess Your Mark</div>
        </div>
    </a>
</header>

<?php


$nr_mat = $email =  $password = $confirm_password = $raspuns = $intrebari= "";

$test = true;
$quest = array();
$servername="localhost";
$username="serb_costa";
$password="pass";
$dbname="TW_database";
$conn = new mysqli($servername, $username, $password, $dbname);


$sql_info_student0 = "SELECT text_intrebare FROM intrebari";
$student_info_query0 = $conn->prepare($sql_info_student0);
$student_info_query0->execute();
$rest = $student_info_query0->get_result();

while ($data = $rest->fetch_assoc()) {
    $statistic[] = $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nr_mat = $_POST["nr_matricol"];
     {

        $sql_info_student = "SELECT parola FROM studenti WHERE matricola=?";
        $student_info_query = $conn->prepare($sql_info_student);

         if ($student_info_query != false) {

            $student_info_query->bind_param("s", $nr_mat);
            $student_info_query->execute();
            $student_info_query->bind_result($parola);
            $student_info_query->fetch();

            if ($parola !== null) {
                $test=false;
                echo '<script type="text/javascript">alert("Studentul a fost deja inregistrat.");</script>';


            }
        }
        $nr_mat= test_input($_POST["nr_matricol"]);

        $student_info_query->close();

     }
    if ($_POST["confirm_password"] != $_POST["password"]) {
        $test=false;
        echo '<script type="text/javascript">alert("Parola si confirmarea nu corespund.");</script>';


    }

    if($test==true) {

        $email = test_input($_POST["email"]);

        $password = test_input($_POST["password"]);

        $raspuns = test_input($_POST["raspuns"]);

        echo '<script type="text/javascript">alert("Student inregistrat");</script>';
        header('Location:../index.php');
    }

}

function test_input($data)
{
    $data = trim($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>

<div class="form">

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

    Nr. matricol: <input type="text" name="nr_matricol" required>

    <br><br>

    Password:<input type="password" name="password" required >

    <br><br>
    Confirm Password:<input type="password" name="confirm_password" required>

    <br><br>
    E-mail: <input type="email" name="email" required>

    <br><br>
    <?php

    echo"Intrebare de securitate:";

    echo '<select name="intrebare">';

    for($i=0;$i<sizeof($statistic);$i++)
    {
        echo '<option value="' . htmlspecialchars($statistic[$i]['text_intrebare']) . '">'
            . htmlspecialchars($statistic[$i]['text_intrebare'])
            . '</option>';
    }
    echo '</select>';

    ?>
    <br><br>
    Raspuns: <input type="text" name="raspuns" required>

    <br><br>
    <input type="submit" name="submit" value="Inregistrare">

</form>
</div>

<?php
if ($test == 1 && !empty($nr_mat)) {

    $psw = $_POST["password"];
    $matricola = $_POST["nr_matricol"];
    $sql_info_student1 = "UPDATE studenti SET parola=?,email=?,intrebare=?,raspuns=?  WHERE matricola=?";
    $student_info_query1 = $conn->prepare($sql_info_student1);
    if ($student_info_query1 != false) {
        $student_info_query1->bind_param("sssss", md5($_POST["password"]),$_POST["email"],$_POST["intrebare"],$_POST["raspuns"], $_POST["nr_matricol"]);
        $student_info_query1->execute();
    }

    $student_info_query1->close();
}
?>

</body>
</html>