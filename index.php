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
<div id="wrap">
    <header class="main_header">

            <div class="logo">
                <a href="index.php">
                    <div class="app_name">ProGnosiX</div>
                    <div class="slogan">Guess Your Mark</div>
                </a>
            </div>

        <div id="actual_section">

        </div>

    </header>
</div>
<div id="main">

    <div id="login">
        <h3 id="welcome_msg" > Bun venit in aplicatia PrognosiX</h3>
        <form action="" method="post">
            <label>Username:</label>
            <input id="username" name="username"  type="text">
            <label>Parola:</label>
            <input id="password" name="password"  type="password">
            <input name="submit" type="submit" value=" Login ">
            <span><?php echo $error; ?></span>
        </form>
    </div>
    <div class="underline_buttons">
        <a class="register_button" href="user/register.php"><button>Inregistrare</button></a>
        <a class="forgot_pass_button" href="user/forgotForm.php"><button>Parola uitata</button></a>
    </div>
</div>



</body>

</html>
