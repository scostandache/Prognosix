<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Administrator</title>
</head>
    <form action="updateNote.php" method="post" enctype="multipart/form-data">
        Upload XML:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Send File" name="submit">
    </form>

<br>

    <form action="insertEvent.php" method="post">

        Obiect <input type="text" name="obiect"><br>
        Tip <input type="text" name="tip"><br>
        Grupa <input type="text" name="grupa"><br>
        Data inceput: <input type="text" name="inceput"><br>
        Data sfarsit: <input type="text" name="sfarsit"><br>
        <input type="submit" value="Send" name="submit2">
    </form>

</html>