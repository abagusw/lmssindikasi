<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Notifikasi Approve User</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f6f9fc;
      margin: 0;
      padding: 0;
    }
    .container {
      max-width: 600px;
      background-color: #ffffff;
      margin: 40px auto;
      border-radius: 8px;
      padding: 30px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    .header {
      text-align: center;
      padding-bottom: 20px;
    }
    .header img {
      height: 50px;
    }
    .title {
      font-size: 22px;
      font-weight: bold;
      color: #333333;
    }
    .content {
      font-size: 16px;
      color: #444444;
      line-height: 1.6;
    }
    .button {
      display: inline-block;
      margin-top: 25px;
      background-color: #28a745;
      color: #ffffff;
      text-decoration: none;
      padding: 12px 24px;
      border-radius: 6px;
      font-weight: bold;
    }
    .footer {
      font-size: 13px;
      color: #999999;
      text-align: center;
      margin-top: 40px;
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="header">
      <img src="https://yourdomain.com/logo.png" alt="Company Logo">
    </div>

    <div class="title">Akun Anda Telah Disetujui 🎉</div>

    <div class="content">
      <p>Halo <strong><?= $getData['nama_lengkap']; ?></strong>,</p>

      <p>Selamat! Permintaan pendaftaran akun Anda telah berhasil <strong>disetujui</strong> oleh administrator.</p>

      <p>Anda sekarang dapat login ke sistem dan menggunakan semua fitur yang tersedia.</p>

      <p style="text-align: center;">
        <a href="<?= base_url() ?>setup/setpassword/" class="button">Atur Password Sekarang</a>
      </p>

      <p>Jika Anda merasa tidak melakukan pendaftaran, abaikan email ini.</p>

      <p>Terima kasih,<br>
      Tim Support</p>
    </div>

    <div class="footer">
      &copy; <?= date('Y') ?> Nama Perusahaan. Semua hak dilindungi.
    </div>
  </div>

</body>
</html>