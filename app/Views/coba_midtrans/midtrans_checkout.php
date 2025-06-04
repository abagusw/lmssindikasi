<!DOCTYPE html>
<html>
<head>
    <title>Midtrans Checkout</title>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-Tub-Ws0lTTNJ5LCa"></script>
</head>
<body>

<button id="pay-button">Bayar Sekarang</button>

<script>
    document.getElementById('pay-button').addEventListener('click', function () {
        fetch('/midtrans/token', {
		    credentials: 'same-origin'  // penting supaya cookie sesi dikirim
		})// Panggil token
            .then(response => response.json())
            .then(data => {
                snap.pay(data.token, {
                    onSuccess: function (result) {
                        console.log("Success", result);
                        alert("Pembayaran berhasil!");
                    },
                    onPending: function (result) {
                        console.log("Pending", result);
                        alert("Menunggu pembayaran.");
                    },
                    onError: function (result) {
                        console.log("Error", result);
                        alert("Pembayaran gagal.");
                    }
                });
            })
    });
</script>

</body>
</html>
