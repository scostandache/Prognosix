<html>
<head>
    <title>Schimbare parola</title>

</head>
<body>
<form name="frmChange" method="post" action="" onSubmit="return validatePassword()">
    <div style="width:500px;">
        <div class="message"><?php if(isset($message)) { echo $message; } ?></div>

        <table border="0" cellpadding="10" cellspacing="0" width="500" align="center" class="tblSaveForm">

            <tr>
                <td width="40%"><label>Parola actuala</label></td>
                <td width="60%"><input type="password" name="currentPassword" class="txtField"/><span id="currentPassword"  class="required"></span></td>
            </tr>
            <tr>
                <td><label>Noua parola</label></td>
                <td><input type="password" name="newPassword" class="txtField"/><span id="newPassword" class="required"></span></td>
            </tr>
            <td><label>Confirma parola</label></td>
            <td><input type="password" name="confirmPassword" class="txtField"/><span id="confirmPassword" class="required"></span></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" name="submit" value="Submit" class="btnSubmit"></td>
            </tr>
        </table>
    </div>
</form>
</body></html>

<script>
    function validatePassword() {
        var currentPassword,newPassword,confirmPassword,output = true;

        currentPassword = document.frmChange.currentPassword;
        newPassword = document.frmChange.newPassword;
        confirmPassword = document.frmChange.confirmPassword;

        if(!currentPassword.value) {
            currentPassword.focus();
            document.getElementById("currentPassword").innerHTML = "Camp obligatoriu";
            output = false;
        }
        else if(!newPassword.value) {
            newPassword.focus();
            document.getElementById("newPassword").innerHTML = "Camp obligatoriu";
            output = false;
        }
        else if(!confirmPassword.value) {
            confirmPassword.focus();
            document.getElementById("confirmPassword").innerHTML = "Camp obligatoriu";
            output = false;
        }
        if(newPassword.value != confirmPassword.value) {
            newPassword.value="";
            confirmPassword.value="";
            newPassword.focus();
            document.getElementById("confirmPassword").innerHTML = "Parolele nu corespund";
            output = false;
        }
        return output;
    }
</script>

<?php
//http://phppot.com/php/php-change-password-script/
include("../user/session.php");

$servername="localhost";
$username="serb_costa";
$pass="pass";
$DB="TW_database";
$conn= new mysqli($servername,$username,$pass,$DB);


if(count($_POST)>0) {

    $get_pass_query="select parola from studenti where matricola=?";
    $get_pass_query=$conn->prepare($get_pass_query);
    $get_pass_query->bind_param("s",$_SESSION['nr_matricol']);
    $get_pass_query->execute();
    $get_pass_query->bind_result($old_pass);
    $get_pass_query->fetch();
    mysqli_close($conn);




    if(md5($_POST["currentPassword"]) == $old_pass) {


        $conn= new mysqli($servername,$username,$pass,$DB);
        
       $change_pass_query="UPDATE studenti set parola =md5(?) where matricola =?";
       $change_pass_query=$conn->prepare($change_pass_query);
       $change_pass_query->bind_param("ss",$_POST["newPassword"],$_SESSION['nr_matricol'] );
       $change_pass_query->execute();
       mysqli_close($conn);
      // header('location:../profile_page/home.php');
       echo "<div id='succes_msg'>Parola schimbata cu succes </div>";
       header("refresh:1;url=../profile_page/home.php" );
    }
    else $message = "Parola gresita";
}
?>