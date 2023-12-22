<?php
// Giriş yapılmış bir oturum kontrolü yap
session_start();

// Oturumda kullanıcı bilgileri var mı diye kontrol et
if (!isset($_SESSION["id"]) || !isset($_SESSION["kullanici_adi"])) {
  // Eğer oturumda kullanıcı bilgileri yoksa, giriş sayfasına yönlendir
  header("Location: index.php");
  exit();
}

// Oturumda kullanıcı bilgileri varsa, sayfayı normal şekilde göster
?>
<!DOCTYPE html>
<html lang="tr">

<head>
  <meta charset="UTF-8" />
  <title>Kendi Anketini Oluştur</title>
  <link rel="stylesheet" type="text/css" href="style.css" />
  <style>
    .container {
      max-width: 800px;
      margin-left: 20%;
      margin-top: 7%;
      padding: 30px;
      background: rgb(204, 181, 165);
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      position: relative;
    }

    h1 {
      position: absolute;
      margin-left: 25%;
      margin-top: -10%;
      color: rgb(204, 181, 165);
      font-size: 36px;
      text-shadow: 2px 2px 3px #333;
    }

    form {
      margin: 20px 0;
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

    .anket-form {
      display: none;
      margin-top: 20px;
    }

    .anket-form label {
      margin-top: 10px;
    }

    .publish-button {
      position: absolute;
      bottom: -40px;
      right: 10px;
      background: #3498db;
      color: #fff;
      padding: 10px 20px;
      border: none;
      cursor: pointer;
      font-size: 16px;
      border-radius: 5px;
      transition: background-color 0.3s, color 0.3s;
    }

    .publish-button:hover {
      background: #2980b9;
    }
  </style>
</head>

<body>
  <div class="container">
    <a href="index.php">
      <h1>Kendi Anketini Oluştur</h1>
    </a>
    <form id="soruForm" method="post" action="anketekle.php">
      <!-- Diğer form alanları -->

      <input type="hidden" id="ad_soyad" name="kullaniciadi" value="<?php echo $_SESSION["kullanici_adi"]; ?>" required />

      <!-- Diğer form alanları devam ediyor... -->


      <label for="anketadı">Anket Adı</label>
      <input type="text" id="anketadı" name="anketadı" required />
      <label for="ad_soyad">Ad Soyad:</label>

      <input type="text" id="ad_soyad" name="kullanici_adi_soyadi" required />

      <label for="tc_no">TC Kimlik Numarası:</label>
      <input type="text" id="tc_no" name="tc_kimlik_numarasi" required />

      <label for="email">E-posta Adresiniz:</label>
      <input type="email" id="email" name="e_mail" required />

      <label for="telefon_no">Telefon Numarası:</label>
      <input type="tel" id="telefon_no" name="telefon_numarasi" required />

      <label for="cinsiyetinizi_seciniz">Cinsiyetinizi Seçiniz:</label>
      <select type="text" id="cinsiyetinizi_seciniz" name="cinsiyet" required>
        <option value="kadın">Kadın</option>
        <option value="erkek">Erkek</option>
        <option value="diger">Diğer</option>
      </select>

      <label for="soru">Sorular</label>
      <button type="submit">Anketi Gönder</button>
    </form>

    <button type="button" onclick="soruEkle()">Soru Ekle</button>
</body>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Formdan gelen verileri al
  $kullaniciAdi = $_POST["kullaniciadi"];
  $kullaniciAdiSoyadi = $_POST["kullanici_adi_soyadi"];
  $tcKimlikNumarasi = $_POST["tc_kimlik_numarasi"];
  $email = $_POST["e_mail"];
  $telefonNumarasi = $_POST["telefon_numarasi"];
  $cinsiyet = $_POST["cinsiyet"];

  // Soruları al
  $sorular = array();
  for ($i = 1; $i <= 6; $i++) {
    $soruName = "soru" . $i;
    if (isset($_POST[$soruName])) {
      $sorular[] = $_POST[$soruName];
    }
  }

  // Veritabanına kaydetme işlemleri burada yapılır (örneğin, MySQL kullanarak)

  // Kaydetme işlemleri tamamlandıktan sonra anketseç.php sayfasına yönlendir
  header("Location: anketseç.php");
  exit();
}
?>
<script>
  function soruEkle() {
    // Yeni bir soru metin kutusu oluştur
    var yeniSoru = prompt("Yeni Soru Ekleyin:");

    if (yeniSoru) {
      // Formu seçin
      var form = document.getElementById("soruForm");

      // Mevcut soru sayısını alın
      var mevcutSoruSayisi = form.querySelectorAll('input[type="text"]').length;

      // Yeni soru sayısını belirleyin
      var yeniSoruSayisi = mevcutSoruSayisi + 1;

      // Soruyu metin kutusuna ekleyin
      var soruMetinKutusu = document.createElement("input");
      soruMetinKutusu.type = "text";
      soruMetinKutusu.value = yeniSoru;
      soruMetinKutusu.name = "soru" + yeniSoruSayisi;
      soruMetinKutusu.required = true;

      // Soruyu hidden alana ekleyin
      var soruHidden = document.createElement("input");
      soruHidden.type = "hidden";
      soruHidden.name = "soru" + yeniSoruSayisi + "_hidden";
      soruHidden.value = yeniSoru;

      // Forma soru metin kutusunu ve hidden alanını ekleyin
      form.appendChild(soruMetinKutusu);
      form.appendChild(soruHidden);
    }
  }
</script>







</html>