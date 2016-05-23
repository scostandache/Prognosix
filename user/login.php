<?php
//https://www.formget.com/login-form-in-php/

session_start();
$error='';
if (isset($_POST['submit'])) {


    if (empty($_POST['nr_matricol']) || empty($_POST['password'])) {
        $error = "Nr. matricol sau parola invalide";
    }

    else {

        $nr_matricol=$_POST['nr_matricol'];
        $pass=$_POST['password'];

        $servername="localhost";
        $username="serb_costa";
        $db_pass="pass";
        $DB="TW_database";
        $conn= new mysqli($servername,$username,$db_pass,$DB);

        if ($conn->connect_error) {

            die("Connection failed: " . $conn->connect_error);

        }

        $sql_info_student="SELECT nume,prenume,email,grupa from studenti where matricola = ? and parola= ?";

        $student_info_query=$conn->prepare($sql_info_student);
        $student_info_query->bind_param("ss",$nr_matricol,md5($pass) );
        $student_info_query->execute();
        $student_info_query->bind_result($nume,$prenume,$email,$grupa);
        $student_info_query->fetch();

        if($nume!=NULL){

            $_SESSION['nr_matricol']=$nr_matricol;
            $_SESSION['nume']=$nume;
            $_SESSION['prenume']=$prenume;
            $_SESSION['grupa']=$grupa;
            $_SESSION['email']=$email;

            header("location: profile_page/home.php");

        }else {
            $error = "Numarul matricol sau parola invalide !";
        }

        $conn->close();

    }


}