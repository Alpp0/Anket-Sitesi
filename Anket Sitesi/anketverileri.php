<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ad_soyad = htmlspecialchars($_POST["kullanici_adi_soyadi"]);
    $tc_no = htmlspecialchars($_POST["tc_kimlik_numarasi"]);
    $email = htmlspecialchars($_POST["e_mail"]);
    $telefon_no = htmlspecialchars($_POST["telefon_numarasi"]);
    $cinsiyetinizi_seciniz = htmlspecialchars($_POST["cinsiyet"]);
    $ayak_numarasi = htmlspecialchars($_POST["ayak_numarasi"]);
    $kac_tane_ayakkabi = htmlspecialchars($_POST["ayakkabi_adedi"]);
    $elinizde_bulunan_mevcut_ayakkabilarinizin_markasi = htmlspecialchars($_POST["elinde_bulunan_markalar"]);
    $en_sevdiginiz_marka = htmlspecialchars($_POST["en_cok_sevdigi_ayakkabi_markasi"]);
    $sevilen_tur = htmlspecialchars($_POST["en_cok_sevdigi_ayakkabi_turu"]);

    $host = "localhost";
    $kullanici = "root";
    $sifre = "";
    $vt = "anketsitesi";
    $baglanti = mysqli_connect($host, $kullanici, $sifre, $vt);

    if (!$baglanti) {
        die("Veritabanı bağlantısı başarısız: " . mysqli_connect_error());
    }

    $sql = "INSERT INTO veriler (kullanici_adi_soyadi, tc_kimlik_numarasi, e_mail, telefon_numarasi, cinsiyet, ayak_numarasi, ayakkabi_adedi, elinde_bulunan_markalar, en_cok_sevdigi_ayakkabi_markasi, en_cok_sevdigi_ayakkabi_turu) VALUES ('$ad_soyad', '$tc_no', '$email', '$telefon_no', '$cinsiyetinizi_seciniz', '$ayak_numarasi', '$kac_tane_ayakkabi', '$elinizde_bulunan_mevcut_ayakkabilarinizin_markasi', '$en_sevdiginiz_marka', '$sevilen_tur')";

    if (mysqli_query($baglanti, $sql)) {
        echo "<h2>Anket Sonuçları:</h2>";
        echo "<p><strong>Ad Soyad:</strong> $ad_soyad</p>";
        echo "<p><strong>TC Kimlik Numarası:</strong> $tc_no</p>";
        echo "<p><strong>E-posta Adresi:</strong> $email</p>";
        echo "<p><strong>Telefon Numarası:</strong> $telefon_no</p>";
        echo "<p><strong>Cinsiyet:</strong> $cinsiyetinizi_seciniz</p>";
        echo "<p><strong>Ayak Numarası:</strong> $ayak_numarasi</p>";
        echo "<p><strong>Kaç Tane Ayakkabınız Var:</strong> $kac_tane_ayakkabi</p>";
        echo "<p><strong>Mevcut Ayakkabı Markaları:</strong> $elinizde_bulunan_mevcut_ayakkabilarinizin_markasi</p>";
        echo "<p><strong>En Sevilen Marka:</strong> $en_sevdiginiz_marka</p>";
        echo "<p><strong>En Sevilen Tür:</strong> $sevilen_tur</p>";
    } else {
        echo "Hata: " . $sql . "<br>" . mysqli_error($baglanti);
    }

    mysqli_close($baglanti);
} else {
    header("Location: index.php");
    exit();
}
