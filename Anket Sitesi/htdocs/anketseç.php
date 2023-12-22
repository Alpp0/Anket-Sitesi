<?php
// Oturumu başlat
session_start();

// Kullanıcının giriş yapmış olup olmadığını kontrol et
if (isset($_SESSION["id"])) {
    $kullanici_adi = $_SESSION["kullanici_adi"];
} else {
    // Kullanıcı giriş yapmamışsa giriş sayfasına yönlendir
    header("Location: login.php");
    exit();
}

// Çıkış işlemi
if (isset($_POST['logout'])) {
    // Oturumu sonlandır
    session_destroy();

    // Kullanıcıyı index.php sayfasına yönlendir
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ANKET SİTESİ</title>
    <!-- Bootstrap CSS eklentisi -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
        }

        .navbar {
            background-color: #007bff;
            padding: 10px 0;
        }

        .navbar-brand {
            color: #fff;
            font-size: 24px;
            font-weight: bold;
        }

        .navbar-text {
            color: #fff;
            font-size: 16px;
            margin-right: 20px;
        }

        .navbar-toggler-icon {
            background-color: #fff;
        }

        .navbar-dark .navbar-toggler {
            border-color: #fff;
        }

        .navbar-dark .navbar-toggler:hover,
        .navbar-dark .navbar-toggler:focus {
            background-color: #fff;
        }

        .container {
            margin-top: 20px;
        }

        .anketButtonContainer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .anketButton {
            flex: 1;
            margin: 10px;
            padding: 15px 30px;
            font-size: 20px;
            text-align: center;
            text-decoration: none;
            outline: none;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        .anketButton:hover {
            filter: brightness(1.2);
            /* Hover etkisi: Parlaklık artışı */
        }

        .anketOlusturButton,
        .anketSilButton {
            background-color: #b76d30;
            /* Koyu kırmızı */
            color: white;
            border: 2px solid #b76d30;
        }

        .anketOlusturButton:hover,
        .anketSilButton:hover {
            background-color: #b76d30;
            /* Daha koyu kırmızı hover etkisi */
        }

        .anketForm {
            margin-top: 0px;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            /* Hafif gölgelendirme */
        }

        .anketForm label,
        .anketForm select,
        .anketForm input,
        .anketForm button {
            margin: 10px;
        }

        .anketForm button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            color: white;
            background-color: #3498db;
            /* Koyu mavi */
            transition: background-color 0.3s, color 0.3s;
        }

        .anketForm button:hover {
            background-color: #2980b9;
            /* Daha koyu mavi hover etkisi */
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">ANKET SİTESİ</a>
            <div class="collapse navbar-collapse justify-content-end">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <span class="navbar-text mr-3"><?php echo $kullanici_adi; ?></span>
                    </li>
                    <li class="nav-item">
                        <form method="post" class="form-inline">
                            <input type="submit" name="logout" value="Çıkış Yap" class="btn btn-light">
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1>Hoş geldin, <?php echo $kullanici_adi; ?>!</h1>

        <!-- Giriş yapmış kullanıcıya özel sayfa içeriği buraya gelecek -->

        <div class="anketButtonContainer">
            <a class="anketButton anketOlusturButton" href="anketoluştur.php" name="anketOlustur">Anket Oluştur</a>
        </div>

        <h2>Anketleriniz</h2>
        <?php
        // Veritabanı bağlantısı ve sorgusu için gerekli bilgileri ekleyin
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "anketsitesi";

        // Veritabanına bağlan
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Bağlantı hatası kontrolü
        if ($conn->connect_error) {
            die("Bağlantı hatası: " . $conn->connect_error);
        }

        // Anket adlarını al


        // Kullanıcının anket adlarını al
        // Anket adlarını al
        $sql = "SELECT anketadi FROM kullanicianketleri WHERE kullaniciadi = '$kullanici_adi'";
        $result = $conn->query($sql);

        // Sorgu başarısız olursa hatayı göster
        if (!$result) {
            die("Sorgu hatası: " . $conn->error);
        }

        // Anket butonlarını oluştur
        while ($row = $result->fetch_assoc()) {
            echo '<div class="anketButtonContainer">';
            echo '<a class="anketButton btn btn-primary" href="hazırlanananket.php?anketadi=' . $row['anketadi'] . '" name="anketler">' . $row['anketadi'] . '</a>';
            echo '<form method="post" action="" class="form-inline">';
            echo '<input type="hidden" name="anketadi" value="' . $row['anketadi'] . '">';
            echo '<button type="submit" name="delete" class="btn btn-danger">Sil</button>';
            echo '</form>';
            echo '</div>';
        }


        if (isset($_POST['delete'])) {
            // Silinecek anket adını al
            $anketadiToDelete = $_POST['anketadi'];

            // Veritabanında silme işlemi gerçekleştir
            $deleteSQL = "DELETE FROM kullanicianketleri WHERE anketadi = '$anketadiToDelete'";
            if ($conn->query($deleteSQL) === TRUE) {
                echo '<div class="alert alert-success mt-3" role="alert">Anket başarıyla silindi.</div>';
            } else {
                echo '<div class="alert alert-danger mt-3" role="alert">Silme hatası: ' . $conn->error . '</div>';
            }
        }
        ?>
    </div>

    <!-- Bootstrap JS ve Popper.js eklentileri -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>