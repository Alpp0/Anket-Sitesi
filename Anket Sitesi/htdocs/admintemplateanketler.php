<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Paneli</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: "Arial", sans-serif;
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

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table,
        .th,
        .td {
            border: 1px solid #ccc;
        }

        .th,
        .td {
            padding: 10px;
            text-align: left;
        }

        .th {
            background-color: #4CAF50;
            color: white;
        }

        .sil-buton {
            background-color: #dc3545;
            border-color: #dc3545;
            color: #fff;
            padding: 8px 16px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
        }

        .sil-buton:hover {
            background-color: #bd2130;
            border-color: #bd2130;
        }

        .success-message {
            margin-top: 20px;
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            text-align: center;
            display: none;
            border-radius: 5px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
</head>

<body>
    <h1 onclick="window.location.href='index.php'" style="cursor:pointer;">ANKET SİTESİ - Admin Paneli</h1>

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
    $sql = "SELECT anketadi FROM kullanicianketleri";
    $result = $conn->query($sql);
    // Anket silme işlemi
    if (isset($_GET['sil'])) {
        $anketAdi = $_GET['sil'];

        // Silme sorgusu
        $silmeSorgusu = "DELETE FROM kullanicianketleri WHERE anketadi = ?";
        $silmeStatement = $conn->prepare($silmeSorgusu);
        $silmeStatement->bind_param("s", $anketAdi);

        // Silme işlemini gerçekleştir
        if ($silmeStatement->execute()) {
            echo "<div class='alert alert-success'>Anket başarıyla silindi.</div>";
        } else {
            echo "<div class='alert alert-danger'>Anket silinirken bir hata oluştu: " . $silmeStatement->error . "</div>";
        }

        // Statement'i kapat
        $silmeStatement->close();
    }

    ?>

    <div class="anketTable">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Anket Adı</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $row['anketadi']; ?></td>
                        <td>
                            <a class="btn btn-primary" href="anket.php?anketadi=<?php echo $row['anketadi']; ?>">Görüntüle</a>
                        </td>
                        <td>

                            <a class="btn btn-danger" href="?sil=<?php echo $row['anketadi']; ?>" onclick="return confirm('Bu anketi silmek istediğinizden emin misiniz?')">Sil</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS ve diğer gerekli scriptler -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>