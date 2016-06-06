<?php
//https://www.formget.com/login-form-in-php/

session_start();
$error='';
if (isset($_POST['submit'])) {


    if (empty($_POST['username']) || empty($_POST['password'])) {
        $error = "<div id='login_error'>&nbsp;&nbsp;&nbsp;Username-ul sau parola invalide !</div>";
    }

    else {

        $user_name=$_POST['username'];
        $pass=$_POST['password'];

        $servername="localhost";
        $username="serb_costa";
        $db_pass="pass";
        $DB="TW_database";
        $conn= new mysqli($servername,$username,$db_pass,$DB);

        if ($conn->connect_error) {

            die("Connection failed: " . $conn->connect_error);

        }

        $sql_info_student="SELECT nume,prenume,email,grupa,matricola,admin from studenti where username = ? and parola= ?";

        $student_info_query=$conn->prepare($sql_info_student);
        $student_info_query->bind_param("ss",$user_name,md5($pass) );
        $student_info_query->execute();
        $student_info_query->bind_result($nume,$prenume,$email,$grupa,$nr_matricol,$admin);
        $student_info_query->fetch();

        if($nume!=NULL){

            $_SESSION['nr_matricol']=$nr_matricol;
            $_SESSION['nume']=$nume;
            $_SESSION['prenume']=$prenume;
            $_SESSION['grupa']=$grupa;
            $_SESSION['email']=$email;
            $_SESSION['admin']=$admin;
            
            if($admin==0){
            header("location: profile_page/home.php");
            }
            if($admin==1){
                header("location: admin/admin_dash.php");
            }
        }else {
            $error = "<div id='login_error'>&nbsp;&nbsp;&nbsp;Username-ul sau parola invalide !</div>";
        }

        $conn->close();

    }

}