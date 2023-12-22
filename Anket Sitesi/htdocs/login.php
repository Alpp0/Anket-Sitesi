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

// POST yöntemi ile gönderilen form verilerini al
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kullanici_adi = $_POST["kullanici_adi"];
    $sifre = $_POST["sifre"];

    // Kullanıcıyı veritabanından sorgula
    $query = "SELECT * FROM kullaniciler WHERE kullanici_adi = '$kullanici_adi'";
    $result = mysqli_query($baglanti, $query);

    if ($result) {
        // Kullanıcı bulunduysa şifreyi kontrol et
        $row = mysqli_fetch_assoc($result);
        if ($row && password_verify($sifre, $row["sifre"])) {
            // Oturumu başlat
            session_start();

            // Kullanıcı bilgilerini oturuma kaydet
            $_SESSION["id"] = $row["id"];
            $_SESSION["kullanici_adi"] = $row["kullanici_adi"];

            // Oturum başlatıldıktan sonra yönlendirme yapabilirsiniz
            header("Location: anketseç.php");
            exit();
        } else {
            $errorMessage = "Hatalı şifre!";
        }
    } else {
        $errorMessage = "Kullanıcı bulunamadı!";
    }
}

// Bağlantıyı kapat
mysqli_close($baglanti);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Sayfası</title>
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

        .login-container {
            background-color: rgb(244, 150, 91);
            padding: 17px;
            border-radius: 25px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 250px;
            text-align: center;
            margin-right: 7%;
            margin-top: -3%;
            position: relative;
        }

        .login-container h2 {
            color: #333;
            margin-bottom: 40px;
        }

        .login-form {
            margin-top: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            color: #555;
            font-size: 15px;
            font-weight: bold;
        }

        .form-group input {
            width: 80%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 10px;
        }

        .form-group button {
            background-color: rgb(114, 115, 116);
            color: rgb(244, 150, 91);
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 70%;
            font-size: 14px;
            font-weight: bold;
        }

        .error-message {
            color: black;
            font-size: 14px;
            margin-top: 10px;
        }

        .register-button {
            margin-top: -6px;
            font-size: 15px;
            color: rgb(114, 115, 116);
            text-decoration: none;
            display: inline-block;
            padding: 8px 12px;
            background-color: rgb(244, 150, 91);
            border-radius: 5px;
            cursor: pointer;
        }

        .goto-home {
            position: absolute;
            top: -189px;
            right: -761px;
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

        .goto-home:hover {
            background-color: black;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <a href="index.php" class="goto-home">Ana Sayfa</a>
        <h2>Giriş Yap</h2>
        <form class="login-form" method="post">
            <div class="form-group">
                <label for="username">Kullanıcı Adı:</label>
                <input type="text" id="username" name="kullanici_adi" required />
            </div>
            <div class="form-group">
                <label for="password">Şifre:</label>
                <input type="password" id="password" name="sifre" required />
            </div>
            <div class="form-group">
                <button type="submit">Giriş Yap</button>
            </div>
            <?php if (isset($errorMessage)) : ?>
                <p class="error-message"><?php echo $errorMessage; ?></p>
            <?php endif; ?>
        </form>
        <a href="kayıtol.php" class="register-button">Kayıt Ol</a>
    </div>
</body>

</html>