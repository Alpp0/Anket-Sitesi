<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Anket Oluştur</title>
    <!-- Yeni tasarım için CSS -->
    <style>
        body {
            font-family: "Arial", sans-serif;
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        nav {
            background-color: rgb(204, 181, 165);
            padding: 10px;
            text-align: center;
            width: 100%;
            margin-bottom: 20px;
        }

        nav h1 {
            color: black;
            margin: 0;
            cursor: pointer;
        }

        .anketButtonContainer {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .anketButton {
            padding: 15px 30px;
            font-size: 20px;
            text-align: center;
            text-decoration: none;
            outline: none;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
            margin: 10px;
            background-color: rgb(204, 181, 165);
            color: white;
            border: 2px solid black;
        }

        .anketButton:hover {
            filter: brightness(1.2);
        }
    </style>
</head>

<body>
    <nav>
        <h1 onclick="window.location.href='index.php'" style="cursor:pointer;">ANKET SİTESİ</h1>
    </nav>

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

    // Anket butonlarını oluştur
    while ($row = $result->fetch_assoc()) {
        echo '<div class="anketButtonContainer">';
        echo '<a class="anketButton btn anketOlusturButton" href="anket.php?anketadi=' . $row['anketadi'] . '" name="anketler">' . $row['anketadi'] . '</a>';
        echo '</div>';
    }
    ?>

    <!-- Bootstrap JS ve diğer gerekli scriptler -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>