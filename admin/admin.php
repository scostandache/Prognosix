<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Administrator</title>
    <link rel="stylesheet" type="text/css" href="../CSS/style.css">
</head>

<div class = "admin_actiuni">
    <h1>Introducere fisier </h1>
    <form action="updateNote.php" method="post" enctype="multipart/form-data">
        Upload XML:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Send File" name="submit">
    </form>

    <br>

    <h1>Introducere examen </h1>
    <form action="insertEvent.php" method="post">

        Obiect <br><input type="text" name="obiect"><br>
        Tip <br><input type="text" name="tip"><br>
        Grupa <br><input type="text" name="grupa"><br>
        Data inceput: <br><input type="text" name="inceput"><br>
        Data sfarsit: <br><input type="text" name="sfarsit"><br>
        <input type="submit" value="Send" name="submit2">
    </form>
</div>
</html>