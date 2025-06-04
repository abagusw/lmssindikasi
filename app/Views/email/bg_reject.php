<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Akun Anda Ditolak</title>
  <style>
    body {
      font-family: 'Arial', sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 20px;
    }
    .email-container {
      background-color: #ffffff;
      max-width: 600px;
      margin: auto;
      border-radius: 8px;
      padding: 30px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    .header {
      text-align: center;
      border-bottom: 1px solid #ddd;
      padding-bottom: 20px;
    }
    .header h2 {
      margin: 0;
      color: #d9534f;
    }
    .content {
      padding: 20px 0;
    }
    .content p {
      font-size: 16px;
      color: #333;
    }
    .footer {
      font-size: 14px;
      color: #777;
      text-align: center;
      padding-top: 20px;
      border-top: 1px solid #ddd;
    }
  </style>
</head>
<body>
  <div class="email-container">
    <div class="header">
      <h2>Akun Anda Ditolak</h2>
    </div>
    <div class="content">
      <p>Halo <strong><?= esc($getData['nama_lengkap']) ?></strong>,</p>

      <p>Mohon maaf, pendaftaran akun Anda pada sistem kami tidak dapat kami setujui pada saat ini.</p>

      <p>Silakan hubungi administrator atau kirim ulang pendaftaran jika diperlukan.</p>

      <p>Terima kasih telah menggunakan layanan kami.</p>
    </div>
    <div class="footer">
      &copy; <?= date('Y') ?> LMS | Scriptmedia
    </div>
  </div>
</body>
</html>