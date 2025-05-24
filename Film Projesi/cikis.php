<?php
session_start();
if (isset($_SESSION["KullaniciAdi"])) {
    $KullaniciAdi = $_SESSION["KullaniciAdi"];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?php
    if (isset($_SESSION["KullaniciAdi"])) {
        unset($_SESSION["KullaniciAdi"]);
        unset($_SESSION["Kullaniciid"]);
        unset($_SESSION["sifre"]);

        header("Location: AnaSayfa.php?sayfa=1");
    } else {
        header("Location: AnaSayfa.php?sayfa=1");
    }
    ?>


</body>

</html>