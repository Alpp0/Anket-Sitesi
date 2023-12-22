<?php
$host = "localhost";
$kullanici = "root";
$sifre = "";
$vt = "anketsitesi";
$baglanti = mysqli_connect($host, $kullanici, $sifre, $vt);

// MySQL bağlantısını oluştur
$conn = new mysqli($host, $kullanici, $sifre, $vt);

// Bağlantıyı kontrol et
if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

// Silme işlemi
if (isset($_POST['sil'])) {
    $userId = $_POST['id'];
    $silmeSql = "DELETE FROM kullaniciler WHERE id = $userId";
    if ($conn->query($silmeSql) === TRUE) {
        echo "<script>alert('Kullanıcı başarıyla silindi.');</script>";
    } else {
        echo "<script>alert('Kullanıcı silme hatası: " . $conn->error . "');</script>";
    }
}

// Kullanıcıları çek
$sql = "SELECT * FROM kullaniciler";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Kullanıcılar</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Custom styles for this template -->
    <style>
        body {
            padding-top: 56px;
        }

        .main {
            margin-top: 56px;
            padding: 20px;
            margin-right: auto;
        }

        .sil-buton {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .sil-buton:hover {
            background-color: #bd2130;
            border-color: #bd2130;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="admintemplate.php">Admin Paneli</a>
        <!-- Diğer navbar bileşenleri buraya eklenebilir -->
    </nav>

    <div class="container-fluid">
        <div class="row">
            <main role="main" class="col-md-9 ml-sm-auto main">
                <h1 class="mt-5">Kullanıcılar</h1>

                <!-- Kullanıcıları gösteren tablo -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Kullanıcı Adı</th>
                            <th>Email</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row["id"] . "</td>";
                                echo "<td>" . $row["kullanici_adi"] . "</td>";
                                echo "<td>" . $row["eposta"] . "</td>";
                                echo "<td><form method='post' action=''>
                                        <input type='hidden' name='id' value='" . $row["id"] . "'>
                                        <button type='submit' name='sil' class='btn btn-danger sil-buton'>Kullanıcıyı Sil</button>
                                    </form></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>Kullanıcı bulunamadı.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS ve diğer gerekli scriptler -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>