document.addEventListener('DOMContentLoaded', function () {
    const paymentForm = document.getElementById('payment-form');
    const totalAmount = document.getElementById('total-amount');

    // Toplam tutarı rezervasyon sayfasından al (örneğin, URL parametresi olarak geçirebilirsiniz)
    const urlParams = new URLSearchParams(window.location.search);
    const total = urlParams.get('total');
    totalAmount.textContent = total;

    paymentForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(paymentForm);

        fetch('odeme_isle.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Ödeme başarılı!');
                window.location.href = 'tesekkurler.html'; // Başarılı ödeme sonrası yönlendirme
            } else {
                alert('Ödeme başarısız: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Hata:', error);
            alert('Ödeme işleminde bir hata oluştu.');
        });
    });
});
