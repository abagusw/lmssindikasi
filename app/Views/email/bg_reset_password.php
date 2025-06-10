<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Reset Your Password</title>
  <style>
    .button {
      display: inline-block;
      padding: 12px 24px;
      font-size: 16px;
      color: #ffffff;
      background-color: #007bff;
      text-decoration: none;
      border-radius: 6px;
    }
    .container {
      max-width: 600px;
      margin: auto;
      padding: 20px;
      font-family: Arial, sans-serif;
      background-color: #f8f9fa;
      border: 1px solid #e0e0e0;
      border-radius: 10px;
    }
    .footer {
      margin-top: 30px;
      font-size: 12px;
      color: #888888;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Reset Your Password</h2>
    <p>Hello, <?= esc($getData['nama_lengkap']) ?></p>
    <p>You recently requested to reset your password. Follow this link to reset and set up a new password:</p>
    <p style="text-align: center; margin: 30px 0;">
      <a href="<?= base_url() ?>setup/setpassword/<?= $getData['id'] ?>" class="button">Set Password</a>
    </p>
    <p>If you did not request a password reset, please ignore this email or contact support if you have questions.</p>
    <p class="footer">This link will expire in 24 hours for your security.</p>
  </div>
</body>
</html>