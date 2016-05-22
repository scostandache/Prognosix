<?php
$servername="localhost";
$username="serb_costa";
$db_pass="pass";
$DB="TW_database";
$conn= new mysqli($servername,$username,$db_pass,$DB);

if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);

}
session_start();
$user_check=$_SESSION['nr_matricol'];

$sql_info_student="SELECT nume from studenti where matricola =  ?";

$student_info_query=$conn->prepare($sql_info_student);
$student_info_query->bind_param("s",$user_check);
$student_info_query->execute();
$student_info_query->bind_result($nume);
$student_info_query->fetch();


if($nume==NULL){

    $conn->close();
   header('Location:../index.php');

}


?>