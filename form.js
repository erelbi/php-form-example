
  function kontrolForm() {
    var adı = document.forms["Form"]["K_adi"].value;
    var soyadı = document.forms["Form"]["K_soyadi"].value;
    var kadro = document.forms["Form"]["Kadro_B"].value;
    var tarih = document.forms["Form"]["B_Tarihi"].value;
    if (adı == null || adı == "", soyadı == null || soyadı == "", kadro == null || kadro == "", tarih == null || tarih == "") {
      alert("Lütfen Tüm alanları doldurunuz");
      return false;
    }
  }
