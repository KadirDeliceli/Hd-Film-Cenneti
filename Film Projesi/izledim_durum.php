<?php
session_start();
include("veri_tabanı.php");

$film_id = $_POST['film_id'];
$kullanici_id = $_POST['kullanici_id'];

// Kaydetme durumunu kontrol et
$kontrol = mysqli_query($VeritabaniBaglantisi, "SELECT * FROM izlenme WHERE film_id = $film_id AND kullanici_id = $kullanici_id");

if (mysqli_num_rows($kontrol) > 0) {
    echo "izlendi";  // Film izlenme kaydedildi
} else {
    echo "izlenmedi";  // Film izlenme kaydedilmedi
}
mysqli_close($VeritabaniBaglantisi);
?>
