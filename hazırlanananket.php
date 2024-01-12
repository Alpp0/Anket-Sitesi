<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "anketsitesi";
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantı hatası kontrolü
if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

// URL'den anket adı parametresini al
$anketAdi = isset($_GET['anketadi']) ? $_GET['anketadi'] : '';

// Anket adını veritabanından çek
$anketAdiBaslik = '';
if (!empty($anketAdi)) {
    $anketAdiSorgu = "SELECT * FROM kullanicianketleri WHERE anketadi = '$anketAdi' LIMIT 1";
    $anketAdiSonuc = $conn->query($anketAdiSorgu);

    if ($anketAdiSonuc && $anketAdiSonuc->num_rows > 0) {
        $anketAdiRow = $anketAdiSonuc->fetch_assoc();
        $anketAdiBaslik = $anketAdiRow['anketadi'];
        // Kullanıcı bilgilerini çek
        $kullaniciAdiSoyadi = $anketAdiRow['ad_soyad'];
        $tcKimlik = $anketAdiRow['tc_kimlik'];
        $ePosta = $anketAdiRow['eposta'];
        $telefon = $anketAdiRow['telefon'];
        $cinsiyet = $anketAdiRow['cinsiyet'];
    }
}



// Anket sorgusu
$sql = "SELECT * FROM kullanicianketleri WHERE anketadi = '$anketAdi'";
$anket = $conn->query($sql);

// Sorgu hatası kontrolü
if ($anket === false) {
    die("Sorgu hatası: " . $conn->error);
}

// Sütun isimleri
$sutunlar = array('soru_1', 'soru_2', 'soru_3', 'soru_4', 'soru_5', 'soru_6', 'soru_7', 'soru_8', 'soru_9', 'soru_10');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $anketAdiBaslik; ?></title>
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

        .user-info {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
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
            display: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="user-info">
            <p>Ad Soyad: <?php echo $kullaniciAdiSoyadi; ?></p>
            <p>TC Kimlik Numarası: <?php echo $tcKimlik; ?></p>
            <p>E-posta Adresiniz: <?php echo $ePosta; ?></p>
            <p>Telefon Numarası: <?php echo $telefon; ?></p>
            <p>Cinsiyetinizi Seçiniz: <?php echo $cinsiyet; ?></p>
        </div>

        <h1><?php echo $anketAdiBaslik; ?></h1>
        <form id="anketForm" method="post" action="anketverileri.php">
            <?php
            // Veritabanından çekilen soruları soru cevap şeklinde ekle
            $anketRow = $anket->fetch_assoc();
            foreach ($sutunlar as $sutun) {
                $soru = $anketRow[$sutun];
                echo "<label for=\"$sutun\">$soru:</label>";
                echo "<input type=\"text\" id=\"$sutun\" name=\"$sutun\" required />";
            }
            ?>

            <button type="submit" onclick="showSuccessMessage()">Gönder</button>
        </form>

        <!-- Yeni eklenen alan -->
        <div id="successMessage" class="success-message" color=" rgb(204, 181, 165)">
            Anketiniz alınmıştır. Teşekkür ederiz!
        </div>
    </div>

    <script>
        function showSuccessMessage() {
            document.getElementById("anketForm").style.display = "none";
            document.getElementById("successMessage").style.display = "block";
        }
    </script>
</body>

</html>