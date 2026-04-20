<?php

if(isset($_POST["kirim"])) {
    echo $_POST ["nama"];
    echo $_POST ["umur"];
}
?>



<html>
    <body>
        <form action="" method="post">
            <label>nama</label>
            <input type="text" name="nama">
            <label>umur</label>
            <input type="number" name="umur">
            <input type="submit" value="kirim" name="kirim">
        </form>
    </body>
</html>