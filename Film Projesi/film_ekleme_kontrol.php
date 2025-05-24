<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Kontrol</title>

    <link rel="stylesheet" href="css/film_ekleme_kontrol.css"> <!-- CSS dosyasını bağlama -->

    <link rel="icon" type="image/png" href="profilResimlari/logo.jpg">
</head>

<body>
    <a href="AnaSayfa.php?sayfa=1" class="btn">Ana Sayfa</a>

    <div class="container">
        <h2>Giriş Yap</h2>
        <form action="film_ekleme_kontrol.php" method="post">
            <label for="kullaniciadi">Kullanıcı Adı:</label>
            <input type="text" name="kullaniciadi" id="kullaniciadi" required><br>

            <label for="sifre">Şifre:</label>
            <input type="password" name="şifre" id="sifre" required><br>

            <input type="submit" value="GİRİŞ YAP">
        </form>

        <?php
        if (isset($_POST["kullaniciadi"]) && isset($_POST["şifre"])) {
            $gelenkullaniciadi = $_POST["kullaniciadi"];
            $gelensifre = $_POST["şifre"];

            if ($gelenkullaniciadi == "admin" && $gelensifre == "admin") {
                header("Location: film_ekle.php");
                exit();
            } else {
                echo "<p class='message' style='color: red;'>Kullanıcı adı veya şifre hatalı...</p>";
            }
        }
        ?>
    </div>
</body>

</html>