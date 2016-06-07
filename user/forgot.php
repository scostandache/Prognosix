<?php
require_once('C:\Program Files (x86)\Ampps\www\Prognosix\PHPMailer-master\PHPMailerAutoload.php');
$servername = "localhost";
$username = "serb_costa";
$password = "pass";
$dbname = "TW_database";

$connection = new mysqli($servername, $username, $password, $dbname);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$matricola = $_POST[matricola];
$intrebare = $_POST[intrebare];
$raspuns = $_POST[raspuns];


$sql = "select matricola, username, email, intrebare, raspuns from studenti where matricola ='" . $matricola ."'";
$result = $connection->query($sql);
$row = $result->fetch_assoc();

if(strlen($row["matricola"]) == 0){
    echo "Matricola nu exista.";
}
else{
    //echo $row["intrebare"] . $row["raspuns"];
    if($intrebare != $row["intrebare"] or $raspuns != $row["raspuns"]){
        echo "Intrebarea sau raspunsul e incorect.";
    }
    else{
        $chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $lenChars = strlen($chars);
        for($i = 0; $i < 15; $i++){
            $random = rand(0, $lenChars - 1);
            $newPass = $newPass . $chars[$random];
        }

        //$headers =  'MIME-Version: 1.0' . "\r\n";
        //$headers .= 'From: Admin <tazputazpu@gmail.com>' . "\r\n";
        //$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        $mesaj = "Username-ul tau este:" . $row["username"] . "<br>" ."Noua ta parola este:" . $newPass;

        //mail($row["email"], "Forgot Password", $mesaj, $headers);

        /*$query = "UPDATE studenti
              SET parola= '" . $newPass .
            " ' WHERE matricola ='" . $matricola . "'";

        if ($connection->query($query) === FALSE) {
            echo "Fail update password: " . $connection->error;
        }*/

        $insertStm  = $connection->prepare("UPDATE studenti
                                            SET parola = ?
                                            WHERE matricola = ?");

        $insertStm->bind_param("ss", md5($newPass), $matricola);
        if ($insertStm->execute() == FALSE){
            echo "Fail change password " . $insertStm->error. "<br>";
        }
        else{
            //echo $mesaj;
            $mail = new PHPMailer(); // create a new object
            $mail->IsSMTP(); // enable SMTP
            $mail->SMTPDebug = false; // debugging: 1 = errors and messages, 2 = messages only
            $mail->do_debug = 0;
            $mail->SMTPAuth = true; // authentication enabled
            $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
            $mail->Host = "smtp.gmail.com";
            $mail->Port = 465;
            $mail->IsHTML(true);
            $mail->Username = "prognosix.updates@gmail.com";
            $mail->Password = "Pr0gnosix";
            $mail->SetFrom("prognosix.updates@gmail.com");
            $mail->Subject = "Resetare parola";
            $mail->Body = $mesaj;
            $mail->AddAddress($row["email"]);

            if(!$mail->Send()) {
                echo "Email Error: " . $mail->ErrorInfo;
            } else {
                echo "Un mail cu noua parola a fost trimis.";
            }
        }
    }

}

mysqli_close($connection);
header( "refresh:1;url=../index.php" );
?>