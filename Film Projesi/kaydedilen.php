<?php
session_start();
include("veri_tabanı.php");
if (isset($_SESSION["KullaniciAdi"])) {
    $KullaniciAdi = $_SESSION["KullaniciAdi"];
?>
    <!DOCTYPE html>
    <html lang="tr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Kaydedilen Filmler</title>

        <link rel="stylesheet" href="css/anasayfa.css"> 
        <link rel="stylesheet" href="css/dropdown.css"> 
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

        <link rel="icon" type="image/png" href="profilResimlari/logo.jpg">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    </head>

    <body>
        <div class="navbar-container">

            <?php
            if (isset($_SESSION["KullaniciAdi"])) {
                $kullanıcıid = $_SESSION['Kullaniciid'];
                $sorgu = mysqli_query($VeritabaniBaglantisi, "SELECT resim_yolu FROM profilyolu WHERE kullanici_id = '$kullanıcıid'");
                if ($sorgu && mysqli_num_rows($sorgu) > 0) {
                    $veri = mysqli_fetch_assoc($sorgu);
                    $profilResmiYolu = $veri['resim_yolu'];
                } else {
                    $profilResmiYolu = "profilResimlari/varsayilan_avatar.png"; // Yüklenmemişse varsayılan resim
                }
                echo '<div class="navbar" style="position: absolute; top: 0px; right: 0px; color:black; background-color:#ffcc00; border-radius: 10px; padding: 8px 15px; display: flex; align-items: center; gap: 50px;">
                <span><strong>' . htmlspecialchars($KullaniciAdi) . '</strong></span>
                <img src="' . $profilResmiYolu . '" alt="Profil" style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover;">
            </div>';
            } else {
                echo "HdfilmCenneti";
            }
            ?>



            <div class="dropdown">
                <a href="profil.php"><i class="fas fa-cog"></i> Profil Ayarlarım</a>
                <a href="kaydedilen.php"><i class="fas fa-list"></i> Kayıt Edilen Filmler</a>
                <a href="begenilen.php"><i class="fas fa-heart"></i> Beğenilen Filmler</a>
                <a href="izlenen.php"><i class="fas fa-eye"></i> İzlenen Filmler</a>
                <a href="cikis.php"><i class="fas fa-sign-out-alt"></i> Çıkış Yap</a>
            </div>
        </div><br><br>

        <script>
            $(document).ready(function() {
                $(".navbar").click(function() {
                    $(".dropdown").toggle();
                });

                $(document).click(function(e) {
                    if (!$(e.target).closest(".navbar-container").length) {
                        $(".dropdown").hide();
                    }
                });
            });
        </script>



        <div class="header">
            <a href="AnaSayfa.php?sayfa=1">
                <div class="logo-container">
                    <img src="profilResimlari/logo.jpg" alt="Film Logosu" width="150" height="100">
                </div>
            </a>
            <div class="overlay"></div> <input type="text" id="arama" placeholder="Film ara..." onkeyup="filmAra()">
            <a href="AnaSayfa.php?sayfa=1" class="btn">Ana Sayfa</a>
        </div>
        <br>
        <div class="film-container">
            <?php

            if (mysqli_connect_errno()) {
                echo "Bağlantı Hatası: " . mysqli_connect_error();
                die();
            }
            $kullanıcıid = $_SESSION['Kullaniciid'];
            $Sorgu1 = mysqli_query($VeritabaniBaglantisi, "SELECT * FROM kaydet WHERE kullanici_id = '$kullanıcıid'");
            if (mysqli_num_rows($Sorgu1) > 0) {
                while ($Kayit1 = mysqli_fetch_assoc($Sorgu1)) {
                    $film_id = $Kayit1["film_id"];
                    $Sorgu = mysqli_query($VeritabaniBaglantisi, "SELECT * FROM filmler WHERE id = $film_id");

                    if ($Kayit = mysqli_fetch_assoc($Sorgu)) {
                        echo "<div class='film' data-film-id='" . $Kayit["id"] . "'>";
                        echo    "<div class='image-container'>";
                        echo        "<div class='film-icons'>"; // <-- BU SATIR ARTIK RESİM KONTEYNERİNİN İÇİNDE
                        echo            "<i class='fas fa-heart begeni' data-id='" . $Kayit["id"] . "' data-type='begeni'></i>";
                        echo            "<i class='fas fa-bookmark kaydet' data-id='" . $Kayit["id"] . "' data-type='kaydet'></i>";
                        echo            "<i class='fas fa-eye izledim' data-id='" . $Kayit["id"] . "' data-type='izledim'></i>";
                        echo        "</div>";
                        echo        "<a href='youtube_Goruntule.php?youtube=" . $Kayit["youtube"] . "'>";
                        echo            "<img src='" . $Kayit["resim"] . "' alt='Film Afişi'>";
                        echo        "</a>";
                        echo    "</div>";
                        echo     "<p class='film-isim'><strong>İsim:</strong> " . $Kayit["isim"] . "</p>";
                        echo     "<p><strong>Puan:</strong> " . $Kayit["puan"] . "</p>";
                        echo     "<a href='" . $Kayit["link"] . "' target='_blank' class='imdb-btn'>IMDb</a>"; // IMDb butonu eklendi
                        echo "</div>";
                    }
                }
            } else {
                echo "Henüz film kaydetmediniz";
            }

            mysqli_close($VeritabaniBaglantisi);
            echo "<br><br><br>"
            ?>
        </div>

        <script>
            $(document).ready(function() {
                const kullanici_id = <?php echo $_SESSION["Kullaniciid"]; ?>;

                // Beğenilen filmleri kontrol et ve butonları güncelle
                $(".film").each(function() {
                    const film_id = $(this).data("film-id"); // Her film için benzersiz ID

                    // Beğeninin durumu için AJAX isteği gönder
                    $.post("begeni_durum.php", {
                        film_id: film_id,
                        kullanici_id: kullanici_id
                    }, function(response) {
                        console.log("Beğeni durumu:", response); // Debugging için cevap
                        if (response === "beğenildi") {
                            $(this).find(".begeni").addClass("active"); // Beğeni varsa butonu aktif yap
                        } else {
                            $(this).find(".begeni").removeClass("active"); // Beğeni yoksa butonu pasif yap
                        }
                    }.bind(this)); // .bind(this) kullanarak her film için doğru 'this' bağlanmasını sağlıyoruz

                    // Kaydetme durumu için AJAX isteği gönder
                    $.post("kaydetme_durum.php", {
                        film_id: film_id,
                        kullanici_id: kullanici_id
                    }, function(response) {
                        console.log("Kaydetme durumu:", response); // Debugging için cevap
                        if (response === "kaydedildi") {
                            $(this).find(".kaydet").addClass("active"); // Kaydedilmişse butonu aktif yap
                        } else {
                            $(this).find(".kaydet").removeClass("active"); // Kaydedilmemişse butonu pasif yap
                        }
                    }.bind(this)); // .bind(this) kullanarak her film için doğru 'this' bağlanmasını sağlıyoruz



                    // izlenme durumu için AJAX isteği gönder
                    $.post("izledim_durum.php", {
                        film_id: film_id,
                        kullanici_id: kullanici_id
                    }, function(response) {
                        console.log("izlenme durumu:", response); // Debugging için cevap
                        if (response === "izlendi") {
                            $(this).find(".izledim").addClass("active"); // Beğeni varsa butonu aktif yap
                        } else {
                            $(this).find(".izledim").removeClass("active"); // Beğeni yoksa butonu pasif yap
                        }
                    }.bind(this)); // .bind(this) kullanarak her film için doğru 'this' bağlanmasını sağlıyoruz
                });

                // Beğeni butonuna tıklandığında
                $(".begeni").click(function() {
                    $(this).toggleClass("active");

                    var film_id = $(this).data("id"); // data-id değerini al
                    var kullanici_id = <?php echo $_SESSION['Kullaniciid']; ?>; // PHP'den kullanıcı ID'yi al

                    // AJAX ile beğeni işlemini gönder
                    $.ajax({
                        type: "POST",
                        url: "filmbegeni.php",
                        data: {
                            film_id: film_id,
                            kullanici_id: kullanici_id
                        },
                        success: function(cevap) {
                            console.log("Beğeni işlemi başarılı: " + cevap);
                        },
                        error: function() {
                            console.log("Beğeni işlemi sırasında hata oluştu.");
                        }
                    });
                });

                // Kaydetme butonuna tıklandığında
                $(".kaydet").click(function() {
                    $(this).toggleClass("active");

                    var film_id = $(this).data("id"); // data-id değerini al
                    var kullanici_id = <?php echo $_SESSION['Kullaniciid']; ?>; // PHP'den kullanıcı ID'yi al

                    // AJAX ile kaydetme işlemini gönder
                    $.ajax({
                        type: "POST",
                        url: "filmKaydet.php",
                        data: {
                            film_id: film_id,
                            kullanici_id: kullanici_id
                        },
                        success: function(cevap) {
                            console.log("Kaydetme işlemi başarılı: " + cevap);
                        },
                        error: function() {
                            console.log("Kaydetme işlemi sırasında hata oluştu.");
                        }
                    });
                });

                // izlenme butonuna tıklandığında
                $(".izledim").click(function() {
                    $(this).toggleClass("active");

                    var film_id = $(this).data("id"); // data-id değerini al
                    var kullanici_id = <?php echo $_SESSION['Kullaniciid']; ?>; // PHP'den kullanıcı ID'yi al

                    // AJAX ile izlenme işlemini gönder
                    $.ajax({
                        type: "POST",
                        url: "izlemeKaydet.php",
                        data: {
                            film_id: film_id,
                            kullanici_id: kullanici_id
                        },
                        success: function(cevap) {
                            console.log("izlenme ekleme işlemi başarılı: " + cevap);
                        },
                        error: function() {
                            console.log("izlenme ekleme işlemi sırasında hata oluştu.");
                        }
                    });
                });
            });
        </script>

    <?php
} else {
    header("Location: AnaSayfa.php?sayfa=1");
}
    ?>
    </body>

    </html>