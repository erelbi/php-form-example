<?php
/*
Ergün Elvan Bilsel
*/
//------------------------------ Bugün bir değişkene Atandı --------------------//
$bugununTarihi = date('Y-m-d');
//------------------------------ Bugün bir değişkene Atandı -------------------//
// ------------------------- Veri Tabanı Değişkenleri -------------------------- //
$hostname = "localhost";
$db_name = "Personel";
$user_name = "gazi";
$password = "password";
// ------------------------- Veri Tabanı Değişkenleri -------------------------- //
// ------------------------- Verilen geçersiz Karakterleri Filitreledik -------------------------- //
function gecersiz_karakter_temizleme($degisken){
	$degisken_temizleme = strip_tags($degisken);
	$degisken_temizleme = htmlentities($degisken_temizleme, ENT_QUOTES, 'UTF-8');
	return $degisken_temizleme;
}
// ------------------------- Verilen geçersiz Karakterleri Filitreledik -------------------------- //
// ------------------------- Veri Tabanı Bağlantısı Kontrol-------------------------- //
function baglanti_mysql(){
  //echo "heheheheh    :" . $GLOBALS['sunucu'];
	$connect = mysqli_connect($GLOBALS["hostname"], $GLOBALS["user_name"], $GLOBALS["password"], $GLOBALS["db_name"]);
	if (!$connect) {
		  die("Baglantı Hatası: " . mysqli_connect_error());
	}
	return $connect;
}
// ------------------------- Veri Tabanı Bağlantısı Kontrol-------------------------- //

// -------------------------- Çalışma Süresi Hesaplandı -----------------------------//
function günhesapla($tarih1,$tarih2){
  // 1 gün 24 saat| 24 saat 86400 saniye //
  $hesapla = strtotime($tarih1) - strtotime($tarih2);
  return abs(round($hesapla / 86400));
}
// -------------------------- Çalışma Süresi Hesaplandı -----------------------------//
// --------------------------- Kadro Tekrarlarını Bul + Personel Numarasını Oluştur------------------------------//
function kadrotipisıralaması($Kadro){
  $mysqli = mysqli_connect($GLOBALS["hostname"], $GLOBALS["user_name"], $GLOBALS["password"], $GLOBALS["db_name"]);
  $sonuc= mysqli_query($mysqli,"SELECT COUNT(*)as  sayi FROM PerTablo WHERE Kadro_Birimi = '$Kadro'");
  $array=mysqli_fetch_assoc($sonuc);
  $tekrar= $array['sayi'];
  $kadro = substr($Kadro, 0,3);
  $PersonelNumber = ($kadro.($tekrar+1));
  mysqli_close($mysqli);
  return   $PersonelNumber;
}
// --------------------------- Kadro Tekrarlarını Bul + Personel Numarasını Oluştur ------------------------------//
if(isset($_POST["kayıtformu"])){
  $baglantı = baglanti_mysql();
  // sql_injection açıklarından korumak için mysql_real_escape_string fonksiyonu ile filitreden geçirdik //
	$Ad = mysqli_real_escape_string($baglantı, gecersiz_karakter_temizleme($_POST["K_adi"]));
	$Soyad = mysqli_real_escape_string($baglantı, gecersiz_karakter_temizleme($_POST["K_soyadi"]));
	$Kadro = mysqli_real_escape_string($baglantı, gecersiz_karakter_temizleme($_POST["Kadro_B"]));
  $Tarih = mysqli_real_escape_string($baglantı, gecersiz_karakter_temizleme($_POST["B_Tarihi"]));
  $CalismaSuresi = günhesapla($bugununTarihi, $Tarih);
  $PersonelNo = kadrotipisıralaması($Kadro);
  $sql = "INSERT INTO PerTablo (Adı, Soyadı, Kadro_Birimi, Baslama_Tarihi,Calısma_Süresi,Personel_No) VALUES ('$Ad', '$Soyad', '$Kadro', '$Tarih','$CalismaSuresi', '$PersonelNo')";
	if (mysqli_query($baglantı, $sql)) {
      echo "<h2><font color=blue>Kayıt gerçekleştirildi</font></h2>";
	} else {
		  echo "Hata: " . $sql . "<br>" . mysqli_error($baglantı);
	}
	mysqli_close($baglantı);
}
?>
<!DOCTYPE html>
<!--  form görseli Güzelleştirmek için eklendi -->
<link rel="stylesheet" href="form.css">
<!-- form görseli Güzelleştirmek için eklendi  -->
<!-- Formu değerlinin boş gelmemesi kontrol eden js eklendi -->
<script src="form.js"></script>
<!-- Formu değerlinin boş gelmemesi kontrol eden js eklendi -->
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<div class="container">
  <form action="form.php" method="post" name="Form" onsubmit="return kontrolForm()">
  <input type="hidden" name="kayıtformu" value="1">
    <div class="row">
      <div class="col-25">
        <label for="field"> Adı:</label>
      </div>
      <div class="col-75">
        <input type="text" id="Adi" name="K_adi" placeholder="Kullanıcı Adı">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="field">Soyadi:</label>
      </div>
      <div class="col-75">
        <input type="text" id="Soyadi" name="K_soyadi" placeholder="Kullanıcı Soyadı">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="field">Kadro Birimi:</label>
      </div>
      <div class="col-75">
        <select id="Kadro_Birimi" name="Kadro_B" >
        <option value="Teknik">Teknik Birim</option>
        <option value="İdari">İdari Birim</option>
        <option value="HalklaIL">Halkla İlişkiler</option>
        <option value="BilgiIS">Bilgi İşlem</option>
        </select>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="field">Başlama Tarihi:</label>
      </div>
      <div class="col-75">
        <input type="text" id="Başlama_Tarihi" name="B_Tarihi" placeholder="örn: 2010-10-10">
      </div>
    </div>
    <div class="row">
      <input type="submit" value="Submit">
    </div>
  </form>
</div>
</body>
</html>