
<?php
include("../user/session.php");
$servername="localhost";
$username="serb_costa";
$password="pass";
$dbname="TW_database";
$conn = new mysqli($servername, $username, $password, $dbname);

$exam=$_GET['exam'];

$nota_luata=$_POST['guessed_grade'];

$nr_matricol=$_SESSION['nr_matricol'];

echo $nr_matricol;


$sql_set_grade_query = "UPDATE note SET ghicita = ? where student_matricola = ? and examen_id=?";
$sql_prepared=$conn->prepare($sql_set_grade_query);

if ($sql_prepared != false) {

    $sql_prepared->bind_param('isi', $nota_luata, $nr_matricol, $exam);
    $sql_prepared->execute();
    echo $sql_prepared->affected_rows;
}


$sql_prepared->close();
$conn->close();


header('location: home.php');






?>