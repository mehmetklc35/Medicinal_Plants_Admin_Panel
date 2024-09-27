<?php
$db_name = 'mysql:host=localhost;dbname=medicinal_plants';
$db_user = 'root';
$db_password = '';

try {
    // PDO ile veritabanı bağlantısı
    $conn = new PDO($db_name, $db_user, $db_password);
    // Hata modunu ayarlama
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Başarı mesajı (geliştirme aşamasında kullanılabilir)
    // echo "Connected to the database successfully.";
} catch (PDOException $e) {
    // Hata mesajını log dosyasına yazma
    error_log("Connection failed: " . $e->getMessage());
    echo "Bağlantı hatası oluştu."; // Kullanıcıya genel bir mesaj
}

if (!function_exists('unique_id')) {
  function unique_id() {
      $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $charLength = strlen($chars);
      $randomString = '';

      for ($i = 0; $i < 20; $i++) {
          $randomString .= $chars[random_int(0, $charLength - 1)];
      }

      return $randomString;
  }
}

?>
