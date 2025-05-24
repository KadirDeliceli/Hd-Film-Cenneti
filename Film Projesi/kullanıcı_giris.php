<?php
session_start();
include("veri_tabanı.php");
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kullanıcı Giriş</title>

    <link rel="stylesheet" href="css/kullanıcı_giris.css">

    <link rel="icon" type="image/png" href="profilResimlari/logo.jpg">

</head>

<body>
    <a href="AnaSayfa.php?sayfa=1" class="btn">Ana Sayfa</a>
    <a href="kullanıcı_kayıt.php" class="btn">KAYIT OL</a>

    <div class="container">
        <h2>Kullanıcı Giriş</h2>
        <form action="kullanıcı_giris.php" method="post">
            Kullanıcı Adı: <input type="text" name="kullaniciadi" required><br>
            Şifre: <input type="password" name="sifre" required><br>
            <input type="submit" value="GİRİŞ YAP">
        </form>

        <?php

        if (mysqli_connect_errno()) {
            echo "<p class='message' style='color: red;'>Bağlantı Hatası: " . mysqli_connect_error() . "</p>";
            exit();
        }

        if (isset($_POST["kullaniciadi"]) && isset($_POST["sifre"])) {
            $gelenkullaniciadi = $_POST["kullaniciadi"];
            $gelensifre = $_POST["sifre"];

            $sorgu = "SELECT * FROM kullanici WHERE kullaniciadi = '$gelenkullaniciadi'";
            $kontrol_sonucu = mysqli_query($VeritabaniBaglantisi, $sorgu);

            if ($kontrol_sonucu) { // sorhu başarılımı yani kullanıcı adı tabloda var mı 
                if (mysqli_num_rows($kontrol_sonucu) > 0) { // kullanıcı daha önce kayıt olmuş demek
                    $kayit = mysqli_fetch_assoc($kontrol_sonucu); // kontrol sonucunu alıyoruz
                    if (password_verify($gelensifre, $kayit["sifre"])) { //kullanıcı adı ile şifre eşleşiyor demek
                        $_SESSION["Kullaniciid"] = $kayit["id"];
                        $_SESSION["KullaniciAdi"] = $gelenkullaniciadi;
                        $_SESSION["sifre"] = $gelensifre;
                        /*
                            echo "kullanıcı adı         :   " . $_SESSION["KullaniciAdi"] . "<br>";
                            echo "kullanıcı sifre      :   " . $_SESSION["sifre"]. "<br>";
                            */
                        echo "<p class='message' style='color: green;'>Giriş Başarılı </p>";
                        header("Location: index.php");
                        exit();
                    } else {
                        echo "<p class='message' style='color: red;'>Kullanıcı adı ile şifre eşleşmiyor ... <br> lütfen tekrar deneyiniz.</p>";
                    }
                } else { // kullanıcı adı bulunamadı yani daha önce kayıt olmadı
                    echo "<p class='message' style='color: red;'>Kullanıcı adı buluamadı , Lütfen Önce kayıt olunuz ... </p>";
                }
            } else { // Sorgu başarısız ise hata mesajı göster
                echo "<p class='message' style='color: red;'>Sorgu Hatası: " . mysqli_error($VeritabaniBaglantisi) . "</p>";
            }
        }
        mysqli_close($VeritabaniBaglantisi);
        ?>
    </div>
</body>

</html>