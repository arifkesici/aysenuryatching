<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $client_id = 'CLIENT_ID'; // İş Bankası tarafından sağlanan üye iş yeri numarası
    $store_key = 'STORE_KEY'; // İş Bankası tarafından sağlanan 3D Secure anahtarı
    $amount = $_POST['amount'];
    $oid = uniqid();
    $okUrl = 'https://yourwebsite.com/success.php';
    $failUrl = 'https://yourwebsite.com/fail.php';
    $rnd = microtime();
    $taksit = '';
    $hashstr = $client_id . $oid . $amount . $okUrl . $failUrl . 'Auth' . $taksit . $rnd . $store_key;
    $hash = base64_encode(pack('H*', sha1($hashstr)));

    $postData = array(
        'clientid' => $client_id,
        'amount' => $amount,
        'oid' => $oid,
        'okUrl' => $okUrl,
        'failUrl' => $failUrl,
        'rnd' => $rnd,
        'hash' => $hash,
        'storetype' => '3D',
        'lang' => 'tr',
        'currency' => '949',
        'islemtipi' => 'Auth',
        'pan' => $_POST['card-number'],
        'Ecom_Payment_Card_ExpDate_Month' => substr($_POST['expiry-date'], 0, 2),
        'Ecom_Payment_Card_ExpDate_Year' => substr($_POST['expiry-date'], 3, 4),
        'cvv' => $_POST['cvc']
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://sanalpos.isbank.com.tr/fim/est3Dgate');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    // İş Bankası'ndan gelen cevabı işleyin
    if ($response) {
        echo json_encode(array('success' => true));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Ödeme işlemi başarısız.'));
    }
}
