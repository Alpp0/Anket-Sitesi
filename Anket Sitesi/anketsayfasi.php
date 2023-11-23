<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8" />
    <title>Ayakkabı Anketi</title>
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
        }

        h1 {
            position: absolute;
            margin-left: 17%;
            margin-top: -6%;
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
        <a href="index.php">
            <h1>Ayakkabı Anketi</h1>
        </a>
        <form id="anketForm" method="post" action="anketverileri.php">
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

            <label for="ayak_numarasi">Ayak numaranız nedir?</label>
            <input type="text" id="ayak_numarasi" name="ayak_numarasi" required />

            <label for="kac_tane_ayakkabi">Kaç tane ayakkabınız var?</label>
            <input type="text" id="kac_tane_ayakkabi" name="ayakkabi_adedi" required />

            <label for="elinizde_bulunan_mevcut_ayakkabi">Elinizde bulunan mevcut ayakkabılarınızın markası?</label>
            <input type="text" id="elinizde_bulunan_mevcut_ayakkabi" name="elinde_bulunan_markalar" required />

            <label for="en_sevdiginiz_marka">En çok sevdiğiniz ayakkabı markası nedir?</label>
            <input type="text" id="en_sevdiginiz_marka" name="en_cok_sevdigi_ayakkabi_markasi" required />

            <label for="sevilen_tur">En sevdiğiniz ayakkabı türü:</label>
            <select id="sevilen_tur" name="en_cok_sevdigi_ayakkabi_turu" required>
                <option value="outdoor">Outdoor</option>
                <option value="sneaker">Sneaker</option>
                <option value="sporayakkabi">Spor Ayakkabı</option>
                <option value="bot">Bot</option>
                <option value="cizme">Çizme</option>
                <option value="topuklu">Topuklu</option>
                <option value="klasik">Klasik</option>
            </select>
            <button type="submit" onclick="showSuccessMessage()">Gönder</button>
        </form>

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