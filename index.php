<?php include('user/login.php');

if(isset($_SESSION['login_user'])){
    header("location: profile_page/home.php");
}

?>


<html>
<head>
    <title>PrognosiX</title>
    <link rel="stylesheet" type="text/css" href="CSS/style.css">
</head>

<body>

<header class="main_header">
    <a href="index.php">
        <div class="logo">
            <div class="app_name">ProGnosiX</div>
            <div class="slogan">Guess Your Mark</div>
        </div>
    </a>
    <div id="actual_section">
        
    </div>

</header>

<div id="main">

    <div id="login">

        <form action="" method="post">
            <label>Username :</label>
            <input id="username" name="username"  type="text">
            <label>Parola:</label>
            <input id="password" name="password"  type="password">
            <input name="submit" type="submit" value=" Login ">
            <span><?php echo $error; ?></span>
        </form>
    </div>
    <a class="register_button" href="user/register.php">Inregistrare</a>
    <a class="forgot_pass_button" href="user/forgotForm.php">Parola uitata</a>
</div>



</body>

</html>
