<?php $servername = "localhost"; 
 $username = "gazi"; 
$password = "password"; 
$dbname = "Personel";
// Bağlantı
$conn = new mysqli($servername, $username, $password, $dbname);
// Bağlantı Check
if ($conn->connect_error) { die("Connection failed: " . 
  $conn->connect_error);
}
for ($i=0; $i < 361 ; $i++) {
    $sql = sprintf("INSERT INTO Trigonometri (Açı, Sinüs, Cosinüs) VALUES 
    (%s,%s,%s)",$i, number_format (sin(deg2rad($i)),3), number_format 
    (cos(deg2rad($i)),3)); if ($conn->query($sql) === TRUE) {
        echo $i;
    } else {
        echo "Hata: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
//Test Çıktısı
echo 
"Sayı"."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;sin&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;cos<br>"; 
for ($i=0; $i <361 ; $i++) {
    echo 
    $i."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".number_format 
    (sin(deg2rad($i)),3)."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".number_format 
    (cos(deg2rad($i)),3)."<br>";
}
?>
