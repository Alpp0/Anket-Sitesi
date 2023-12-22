<?php
// Veritabanı bağlantı bilgileri
$host = "localhost";
$kullanici = "root";
$sifre = "";
$vt = "anketsitesi";

// Veritabanı bağlantısını oluştur
$baglanti = mysqli_connect($host, $kullanici, $sifre, $vt);

// Bağlantı kontrolü
if (!$baglanti) {
    die("Veritabanı bağlantısı başarısız: " . mysqli_connect_error());
}

// Hangi ankete katılmak istendiğini kontrol et
$secilenAnketAdi = isset($_GET['anketadi']) ? $_GET['anketadi'] : '';

// Anket sorularını veritabanından çek


$sorguu = "SELECT anket_id FROM kullanicianketleri WHERE anketadi = '$secilenAnketAdi'";
$sorguusonuc = mysqli_query($baglanti, $sorguu);

if ($sorguusonuc === false) {
    // Hata işlemleri
    echo "Sorgu hatası: " . mysqli_error($baglanti);
} else {
    $anketVeri = mysqli_fetch_assoc($sorguusonuc);
    $anketid = $anketVeri['anket_id'];
}

$anketGonderildi = false;

// Gönderilen formu kontrol et
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['anket_gonder'])) {
    // Anket gönderildi flag'ini true yap
    $anketGonderildi = true;

    // Kullanıcı bilgilerini al ve SQL enjeksiyonuna karşı temizle
    $adSoyad = @$_POST['ad_soyad'];
    $tcKimlik = @$_POST['tc_kimlik'];
    $ePosta = @$_POST['e_posta'];
    $telefon = @$_POST['telefon'];
    $cinsiyet = @$_POST['cinsiyet'];

    $cevap1 = @$_POST['cevap_1'];
    $cevap2 = @$_POST['cevap_2'];
    $cevap3 = @$_POST['cevap_3'];
    $cevap4 = @$_POST['cevap_4'];
    $cevap5 = @$_POST['cevap_5'];
    $cevap6 = @$_POST['cevap_6'];
    $cevap7 = @$_POST['cevap_7'];
    $cevap8 = @$_POST['cevap_8'];
    $cevap9 = @$_POST['cevap_9'];
    $cevap10 = @$_POST['cevap_10'];

    // Veritabanına ekleme işlemi

    $cevaplarSorgu = "INSERT INTO publicanketcevapları (AdSoyad, telefon, Tckimliknumarasi, eposta, cinsiyet, anketid,cevap_1, cevap_2, cevap_3, cevap_4, cevap_5, cevap_6, cevap_7, cevap_8, cevap_9, cevap_10) 
    VALUES ('$adSoyad', '$telefon', '$tcKimlik', '$ePosta', '$cinsiyet', '$anketid','$cevap1', '$cevap2', '$cevap3', '$cevap4', '$cevap5', '$cevap6', '$cevap7', '$cevap8', '$cevap9', '$cevap10'
     )";

    // Sorguyu çalıştır
    if (mysqli_query($baglanti, $cevaplarSorgu)) {
        echo "Cevaplar başarıyla eklendi.";
    } else {
        echo "Hata: " . $cevaplarSorgu . "<br>" . mysqli_error($baglanti);
    }
}



$anketBasligi = ''; // Varsayılan başlık
if (!empty($secilenAnketAdi)) {
    // Eğer URL'den anket adı geldiyse, onu kullan
    $anketBasligi = $secilenAnketAdi;
} elseif (isset($_POST['buton_ad'])) {
    // Eğer buton adı gönderildiyse, onu kullan
    $anketBasligi = $_POST['buton_ad'];
}
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8" />
    <title>Kişi Anketi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 30px;
            background: rgb(204, 181, 165);
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: black;
            font-size: 36px;
            text-shadow: 2px 2px 3px #333;
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ccc;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="number"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="radio"] {
            margin-right: 10px;
        }

        button {
            background: black;
            color: #fff;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
        }

        button:hover {
            background: #0056b3;
        }

        .success-message {
            margin-top: 20px;
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            text-align: center;
            display: <?php echo $anketGonderildi ? 'block' : 'none'; ?>;
            border-radius: 5px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .back-button {
            background: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
            position: absolute;
            top: 10px;
            left: 10px;
        }

        .back-button:hover {
            background: #0056b3;
        }

        .geri-don-buton {
            background-color: rgb(204, 181, 165);
            color: #fff;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
            position: fixed;
            top: 10px;
            left: 10px;
        }

        .geri-don-buton:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1><?php echo $anketBasligi; ?> Anketi</h1>
        <form id="anketForm" method="post" action="">
            <!-- Kullanıcı bilgileri giriş formu -->
            <label for="ad_soyad">Ad Soyad:</label>
            <input type="text" id="ad_soyad" name="ad_soyad" required />

            <label for="tc_kimlik">TC Kimlik Numarası:</label>
            <input type="text" id="tc_kimlik" name="tc_kimlik" required />

            <label for="e_posta">E-posta Adresiniz:</label>
            <input type="email" id="e_posta" name="e_posta" required />

            <label for="telefon">Telefon Numarası:</label>
            <input type="tel" id="telefon" name="telefon" required />

            <label>Cinsiyetinizi Seçiniz:</label>
            <label for="erkek">Erkek</label>
            <input type="radio" id="erkek" name="cinsiyet" value="Erkek" required />
            <label for="kadin">Kadın</label>
            <input type="radio" id="kadin" name="cinsiyet" value="Kadın" required />


            <!-- Anket soruları -->
            <?php
            $anketAdi = mysqli_real_escape_string($baglanti, $secilenAnketAdi);

            $sorularSorgu = "SELECT soru_1, soru_2, soru_3, soru_4, soru_5, soru_6, soru_7, soru_8, soru_9, soru_10  FROM kullanicianketleri WHERE anketadi = ?";
            $sorularStatement = mysqli_prepare($baglanti, $sorularSorgu);
            mysqli_stmt_bind_param($sorularStatement, "s", $anketAdi);
            mysqli_stmt_execute($sorularStatement);
            $sayac = 0;
            $sorularSonuc = mysqli_stmt_get_result($sorularStatement);

            if ($sorularSonuc) {
                while ($soru = mysqli_fetch_assoc($sorularSonuc)) {
                    foreach ($soru as $soruNumarasi => $soruIcerigi) {
                        $sayac = $sayac + 1;
                        if (!empty($soruIcerigi)) {
                            echo '<label for="cevap_' . $sayac . '">' . $soruIcerigi . '</label>';
                            echo '<input type="text" id="cevap_' . $sayac . '" name="cevap_' . $sayac . '" required />';
                        }
                    }
                }
            }
            ?>






            <!-- Gönder butonu -->
            <button type="submit" name="anket_gonder">Gönder</button>
        </form>

        <!-- Başarı mesajı -->
        <div class="success-message">
            Cevaplar başarıyla eklendi.
        </div>
    </div>
</body>

</html>