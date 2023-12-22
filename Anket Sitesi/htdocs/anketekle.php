<?php
// Veritabanı bağlantısını sağlayan bilgiler
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "anketsitesi";

// Veritabanı bağlantısını oluştur
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantıyı kontrol et
if ($conn->connect_error) {
    die("Veritabanı bağlantısında hata: " . $conn->connect_error);
}

// Formdan gelen verileri al
$kullaniciAdi = $_POST["kullaniciadi"];
$anketadi = $_POST['anketadı'];
$ad_soyad = $_POST['kullanici_adi_soyadi'];
$tc_kimlik = $_POST['tc_kimlik_numarasi'];
$eposta = $_POST['e_mail'];
$telefon = $_POST['telefon_numarasi'];
$cinsiyet = $_POST['cinsiyet'];
$soru_1 = $_POST['soru4'];
$soru_2 = $_POST['soru5'];
$soru_3 = $_POST['soru6'];
$soru_4 = $_POST['soru7'];
$soru_5 = $_POST['soru8'];
$soru_6 = $_POST['soru9'];
$soru_7 = $_POST['soru10'];
$soru_8 = $_POST['soru11'];
$soru_9 = $_POST['soru12'];
$soru_10 = $_POST['soru13'];

// Veritabanına ekleme sorgusu
$sql = "INSERT INTO kullanicianketleri ( kullaniciadi,anketadi,ad_soyad, tc_kimlik, eposta, telefon, cinsiyet, soru_1, soru_2, soru_3, soru_4, soru_5, soru_6, soru_7, soru_8, soru_9, soru_10)
        VALUES ('$kullaniciAdi','$anketadi','$ad_soyad', '$tc_kimlik', '$eposta', '$telefon', '$cinsiyet', '$soru_1', '$soru_2', '$soru_3', '$soru_4', '$soru_5', '$soru_6','$soru_7','$soru_8','$soru_9','$soru_10')";

// Sorguyu çalıştır ve sonucu kontrol et
if ($conn->query($sql) === TRUE) {
    header("Location: anketseç.php");
    exit();
} else {
    header("Location: anketseç.php");
    exit();
}

// Veritabanı bağlantısını kapat
$conn->close();
