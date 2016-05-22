<?php
include("../user/session.php");
$nume=$_SESSION['nume'];
$prenume=$_SESSION['prenume'];
$grupa=$_SESSION['grupa'];
$email=$_SESSION['email'];
$nr_matricol=$_SESSION['nr_matricol'];

echo
"<ul class=\"student_informations_list\">

                  <li>Nume:".ucfirst($nume)." </li>
                  <li>Prenume:".ucfirst($prenume)." </li>
                  <li>Grupa:".$grupa." </li>
                  <li>E-mail:".$email." </li>
                  <li>Nr. matricol:".$nr_matricol." </li>

</ul>";

?>