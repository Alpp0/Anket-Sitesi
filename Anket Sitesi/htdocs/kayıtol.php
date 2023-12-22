<?php
// Veritabanı bağlantı bilgileri
$host = "localhost";
$kullanici = "root";
$sifre = "";
$vt = "anketsitesi"; // Kullanacağınız veritabanının adını buraya yazın

// Veritabanı bağlantısını oluştur
$baglanti = mysqli_connect($host, $kullanici, $sifre, $vt);

// Bağlantı kontrolü
if (!$baglanti) {
    die("Veritabanı bağlantısı başarısız: " . mysqli_connect_error());
}

// Hata mesajları için değişkenler
$mesaj = "";

// POST yöntemi ile gönderilen form verilerini al
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kullanici_adi = $_POST["kullanici_adi"];
    $eposta = $_POST["eposta"];
    $sifre = $_POST["sifre"];
    $confirmsifre = $_POST["confirm-sifre"];

    // Şifre kontrolü
    if ($sifre != $confirmsifre) {
        $mesaj = "Hata: Şifreler uyuşmuyor!";
    } else {
        // Şifreyi hashle (güvenlik için)
        $hashedsifre = password_hash($sifre, PASSWORD_DEFAULT);

        // Kullanıcıyı veritabanına ekle
        $query = "INSERT INTO kullaniciler (kullanici_adi, eposta, sifre) VALUES ('$kullanici_adi', '$eposta', '$hashedsifre')";

        if (mysqli_query($baglanti, $query)) {
            $mesaj = "Kayıt başarıyla tamamlandı!";
        } else {
            $mesaj = "Kayıt sırasında bir hata oluştu: " . mysqli_error($baglanti);
        }
    }
}

// Bağlantıyı kapat
mysqli_close($baglanti);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Ol Sayfası</title>
    <style>
        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background-image: url("deneme1.jpg");
            background-size: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .register-container {
            background-color: rgb(244, 150, 91);
            padding: 1px;
            border-radius: 25px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 300px;
            height: 50%;
            text-align: center;
            margin-right: 7%;
            margin-top: -3%;
            position: relative;
        }

        .register-container h2 {
            color: #333;
            margin-bottom: 5px;
        }

        .register-form {
            margin-top: 5px;
        }

        .form-group {
            margin-bottom: 13px;
        }

        .form-group label {
            display: block;
            margin-bottom: 0px;
            color: #555;
            font-size: 19px;
            font-weight: bold;
        }

        .form-group input {
            width: 50%;
            padding: 5px;
            border: 3px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        .form-group button {
            background-color: rgb(114, 115, 116);
            color: rgb(244, 150, 91);
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 40%;
            font-size: 14px;
            font-weight: bold;
            margin-top: 5%;
        }

        .login-link {
            margin-top: 19px;
            font-size: 18px;
            color: rgb(255, 255, 255);


        }

        .login-link a {
            color: rgb(114, 115, 116);
            text-decoration: none;
        }

        .mesaj {
            color: rgb(114, 115, 116);
            background-color: white;
            padding: 5px;
            border-radius: 5px;
            margin-top: 10px;
        }

        .goto-index {
            position: absolute;
            top: -150px;
            right: -740px;
            cursor: pointer;
            background-color: rgb(244, 150, 91);
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .goto-index:hover {
            background-color: black;
        }
    </style>
</head>

<body>

    <div class="register-container">
        <a href="index.php" class="goto-index">Ana Sayfa</a>
        <form action="" method="POST">
            <div class="form-group">
                <label for="kullanici_adi">Kullanıcı Adı:</label>
                <input type="text" id="kullanici_adi" name="kullanici_adi" required />
            </div>
            <div class="form-group">
                <label for="eposta">E-posta:</label>
                <input type="email" id="eposta" name="eposta" required />
            </div>
            <div class="form-group">
                <label for="sifre">Şifre:</label>
                <input type="password" id="sifre" name="sifre" required />
            </div>
            <div class="form-group">
                <label for="confirm-sifre">Şifre Tekrarı:</label>
                <input type="password" id="confirm-sifre" name="confirm-sifre" required />
            </div>
            <div class="form-group">
                <button type="submit">Kayıt Ol</button>
            </div>
            <div><?php echo $mesaj; ?></div>
        </form>
        <div class="login-link">
            <a href="login.php">Zaten bir hesabın var mı? Giriş yap</a>
        </div>
    </div>
</body>

</html>