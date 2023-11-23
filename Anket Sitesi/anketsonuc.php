<?php
$host = "localhost";
$kullanici = "root";
$sifre = "";
$vt = "anketsitesi";
$baglanti = mysqli_connect($host, $kullanici, $sifre, $vt);

if (!$baglanti) {
    die("Veritabanı bağlantısı başarısız: " . mysqli_connect_error());
}

$query = "SELECT * FROM veriler";
$result = mysqli_query($baglanti, $query);

echo "<html>";
echo "<head>";
echo "<style>
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }
      </style>";
echo "</head>";
echo "<body>";

echo "<table>
        <tr>
            <th>Cinsiyet</th>
            <th>Ayak Numarası</th>
            <th>Ayakkabı Adedi</th>
            <th>Elinde Bulunan Markalar</th>
            <th>En Çok Sevilen Ayakkabı Markası</th>
            <th>En Çok Sevilen Ayakkabı Türü</th>
        </tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
            <td>{$row['cinsiyet']}</td>
            <td>{$row['ayak_numarasi']}</td>
            <td>{$row['ayakkabi_adedi']}</td>
            <td>{$row['elinde_bulunan_markalar']}</td>
            <td>{$row['en_cok_sevdigi_ayakkabi_markasi']}</td>
            <td>{$row['en_cok_sevdigi_ayakkabi_turu']}</td>
          </tr>";
}

$query_avg = "SELECT AVG(ayak_numarasi) AS ayak_numarasi_ortalama, AVG(ayakkabi_adedi) AS ayakkabi_adedi_ortalama FROM veriler";
$result_avg = mysqli_query($baglanti, $query_avg);
$row_avg = mysqli_fetch_assoc($result_avg);

echo "<table>
        <tr>
            <th>Ayak Numarası Oranı</th>
            <th>Ayakkabı Adedi Oranı</th>
        </tr>";
echo "<tr>
            <td>{$row_avg['ayak_numarasi_ortalama']}</td>
            <td>{$row_avg['ayakkabi_adedi_ortalama']}</td>
          </tr>";

echo "</table>";
echo "</body>";
echo "</html>";

mysqli_close($baglanti);
