<?php
$host = "localhost";
$kullanici = "root";
$sifre = "";
$vt = "anketsitesi";
$baglanti = mysqli_connect($host, $kullanici, $sifre, $vt);

// Bağlantı kontrolü
if (!$baglanti) {
    die("Veritabanı bağlantısı başarısız: " . mysqli_connect_error());
}

// Ayak numaraları verilerini çek
$queryAyakNumarasi = "SELECT ayak_numarasi FROM veriler"; // Tablo adınıza göre güncelleyin
$resultAyakNumarasi = mysqli_query($baglanti, $queryAyakNumarasi);

// Sorgu başarısız olursa hata mesajını yazdır
if (!$resultAyakNumarasi) {
    die("Sorgu hatası: " . mysqli_error($baglanti));
}

// Ayak numaralarını saklamak için bir dizi oluştur
$verilerAyakNumarasi = array();

while ($rowAyakNumarasi = mysqli_fetch_assoc($resultAyakNumarasi)) {
    $verilerAyakNumarasi[] = $rowAyakNumarasi['ayak_numarasi'];
}

// Ayak numaralarının ortalamasını al
$ortalamaAyakNumarasi = count($verilerAyakNumarasi) > 0 ? array_sum($verilerAyakNumarasi) / count($verilerAyakNumarasi) : 0;

// Cinsiyet verilerini çek
$queryCinsiyet = "SELECT cinsiyet FROM veriler"; // Tablo adınıza göre güncelleyin
$resultCinsiyet = mysqli_query($baglanti, $queryCinsiyet);

// Sorgu başarısız olursa hata mesajını yazdır
if (!$resultCinsiyet) {
    die("Sorgu hatası: " . mysqli_error($baglanti));
}

// Cinsiyet sayılarını saklamak için bir dizi oluştur
$cinsiyetler = array();

while ($rowCinsiyet = mysqli_fetch_assoc($resultCinsiyet)) {
    $cinsiyetler[] = $rowCinsiyet['cinsiyet'];
}

// En çok bulunan cinsiyeti belirle
$enCokBulunanCinsiyet = array_count_values($cinsiyetler);
$enCokBulunanCinsiyet = array_search(max($enCokBulunanCinsiyet), $enCokBulunanCinsiyet);


$queryAyakkabiAdedi = "SELECT ayakkabi_adedi FROM veriler"; // Tablo adınıza göre güncelleyin
$resultAyakkabiAdedi = mysqli_query($baglanti, $queryAyakkabiAdedi);
if (!$resultAyakkabiAdedi) {
    die("Sorgu hatası: " . mysqli_error($baglanti));
}
$verilerAyakkabiAdedi = array();
while ($rowAyakkabiAdedi = mysqli_fetch_assoc($resultAyakkabiAdedi)) {
    $verilerAyakkabiAdedi[] = $rowAyakkabiAdedi['ayakkabi_adedi'];
}
$ortalamaAyakkabiAdedi = count($verilerAyakkabiAdedi) > 0 ? array_sum($verilerAyakkabiAdedi) / count($verilerAyakkabiAdedi) : 0;


// En çok bulunan markayı belirle


$querySevdigiMarka = "SELECT en_cok_sevdigi_ayakkabi_markasi FROM veriler"; // Tablo adınıza göre güncelleyin
$resultSevdigiMarka = mysqli_query($baglanti, $querySevdigiMarka);

if (!$resultSevdigiMarka) {
    die("Sorgu hatası: " . mysqli_error($baglanti));
}

$verilerSevdigiMarka = array();

while ($rowSevdigiMarka = mysqli_fetch_assoc($resultSevdigiMarka)) {
    $verilerSevdigiMarka[] = $rowSevdigiMarka['en_cok_sevdigi_ayakkabi_markasi'];
}

// En çok bulunan markayı belirle
$enCokSevdigiMarka = array_count_values($verilerSevdigiMarka);
$enCokSevdigiMarka = array_search(max($enCokSevdigiMarka), $enCokSevdigiMarka);


$querySevdigiTur = "SELECT en_cok_sevdigi_ayakkabi_turu FROM veriler"; // Tablo adınıza göre güncelleyin
$resultSevdigiTur = mysqli_query($baglanti, $querySevdigiTur);

if (!$resultSevdigiTur) {
    die("Sorgu hatası: " . mysqli_error($baglanti));
}

$verilerSevdigiTur = array();

while ($rowSevdigiTur = mysqli_fetch_assoc($resultSevdigiTur)) {
    $verilerSevdigiTur[] = $rowSevdigiTur['en_cok_sevdigi_ayakkabi_turu'];
}

// En çok bulunan türü belirle
$enCokSevdigiTur = array_count_values($verilerSevdigiTur);
$enCokSevdigiTur = array_search(max($enCokSevdigiTur), $enCokSevdigiTur);





// Bağlantıyı kapat
mysqli_close($baglanti);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anket Sonuçları</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-color: #e6e6fa;
            /* Sayfa arka plan rengi */
        }

        .chart {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }

        .slice {
            position: relative;
            width: 180px;
            /* Dilim genişliği */
            height: 180px;
            /* Dilim yüksekliği */
            border-radius: 50%;
            background-color: #e6e6fa;
            /* Pasta grafiğinin arka plan rengi */
            overflow: hidden;
            margin: 50px;
            /* Dilimler arası mesafe */
            box-shadow: 0 0 100px rgba(0, 0, 0, 0.5);
            /* Gölge efekti */
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2em;
            color: #fff;
            /* Metin rengi */
        }

        .inner-text {
            position: absolute;
            font-size: 1em;
            font-weight: bold;
            color: #333;

            /* Metin rengi */
        }


        .baslık {
            position: absolute;
            text-align: center;
            margin-top: -35%;
            margin-left: auto;
            font-family: 'Monoton', cursive;
            font-size: 25px;

        }


        .ayaknumarasi {
            position: absolute;
            text-align: center;
            margin-top: -18%;
            margin-left: -73%;
            width: 10%;
            font-size: large;
            font-family: Arial, Helvetica, sans-serif;

        }

        .cinsiyet {
            position: absolute;
            text-align: center;
            margin-top: -18%;
            margin-left: -36%;
            width: 12%;
            font-size: large;
            font-family: Arial, Helvetica, sans-serif;

        }

        .adet {
            position: absolute;
            text-align: center;
            margin-top: -18%;
            margin-left: -0%;
            width: 12%;
            font-size: large;
            font-family: Arial, Helvetica, sans-serif;
        }

        .marka {
            position: absolute;
            text-align: center;
            margin-top: -18%;
            margin-left: 37%;
            width: 12%;
            font-size: large;
            font-family: Arial, Helvetica, sans-serif;
        }

        .tür {
            position: absolute;
            text-align: center;
            margin-top: -18%;
            margin-left: 72%;
            width: 12%;
            font-size: large;
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
</head>

<body>
    <div class="baslık">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Monoton&display=swap">
        <a href="index.php" style="text-decoration: none; color:black;">
            <h1>ANKET SONUÇLARI</h1>
        </a>
    </div>
</body>

<body>
    <div class="ayaknumarasi">
        <h4>Ortalama Ayak Numarası:</h4>
    </div>
</body>

<body>
    <div class="cinsiyet">
        <h4>Ankete En Çok Katılan Kişilerin Cinsiyeti:</h4>
    </div>
</body>

<body>
    <div class="adet">
        <h4>Sahip Olunan Ortalama Ayakkabı Adedi:</h4>
    </div>
</body>

<body>
    <div class="marka">
        <h4>En Çok Sevilen Ayakkabı Markası:</h4>
    </div>
</body>

<body>
    <div class="tür">
        <h4>En Çok Sevilen Ayakkabı Türü:</h4>
    </div>
</body>

<body>
    <div class="chart">
        <div class="slice" data-slice1="<?php echo $ortalamaAyakNumarasi; ?>">
            <div class="inner-text"><?php echo round($ortalamaAyakNumarasi, 2); ?></div>
        </div>
        <div class="slice" data-slice2="10">
            <div class="inner-text"><?php echo $enCokBulunanCinsiyet; ?></div>
        </div>
        <div class="slice" data-slice3="<?php echo $ortalamaAyakkabiAdedi; ?>">
            <div class="inner-text"><?php echo round($ortalamaAyakkabiAdedi, 2); ?></div>
        </div>
        <div class="slice" data-slice5="10">
            <div class="inner-text"><?php echo $enCokSevdigiMarka; ?></div>
        </div>
        <div class="slice" data-slice6="10">
            <div class="inner-text"><?php echo $enCokSevdigiTur; ?></div>
        </div>
        <!-- Diğer dilimleri ekleyin -->
        <!-- data-slice7, data-slice8, ... -->
    </div>
    <script>
        const slices = document.querySelectorAll(".slice");

        slices.forEach((slice, index) => {
            const rotation = 360 / slices.length * index;
            const color = getRandomColor();
            const sliceValue = parseInt(slice.getAttribute(`data-slice${index + 1}`), 10);

            slice.style.setProperty("--rotate", `${rotation}deg`);
            slice.style.background = `linear-gradient(90deg, ${color} ${sliceValue}%, transparent ${sliceValue}%)`;
        });

        function getRandomColor() {
            const letters = '0123456789ABCDEF';
            let color = '#';
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }
    </script>
</body>

</html>