<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membership SINDIKASI</title>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
        }
        
        .email-container {
            background: white;
            border-radius: 12px;
            padding: 40px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .logo {
            max-width: 120px;
            margin-bottom: 20px;
        }
        
        .title {
            color: #333;
            font-size: 26px;
            font-weight: 700;
            margin: 0;
            line-height: 1.3;
        }
        
        .greeting {
            font-size: 18px;
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }
        
        .steps-container {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 30px;
            margin: 30px 0;
        }
        
        .steps-title {
            color: #333;
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .step {
            display: flex;
            align-items: flex-start;
            margin: 20px 0;
            padding: 15px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .step:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }
        
        .step-number {
            background: #f28c6a;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 15px;
            flex-shrink: 0;
        }
        
        .step-content {
            flex: 1;
        }
        
        .step-title {
            font-weight: 600;
            color: #4f2212;
            margin-bottom: 5px;
        }
        
        .step-description {
            color: #666;
            font-size: 14px;
        }
        
        .cta-button {
            display: inline-block;
            background: #f28c6a;
            color: white;
            padding: 16px 32px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            text-align: center;
            margin: 20px 0;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #e9ecef;
            font-size: 12px;
            color: #666;
        }
        
        .timeline-progress {
            background: linear-gradient(135deg, #27ae60, #2ecc71);
            height: 100%;
            width: 25%;
            border-radius: 1px;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
            <img src="https://sindikasi.org/images/logo_medium.b1bc581.c9be1a476612b6c1bb320543c218d756.png" alt="SINDIKASI Logo" class="logo">
            <h1 class="title">Membership SINDIKASI</h1>
        </div>

        <div class="greeting">
            <strong>Halo <?= $nama_lengkap; ?></strong>
        </div>

        <div class="steps-container">
            <h2 class="steps-title">Agar tetap bisa menikmati manfaat membership SINDIKASI, kamu bisa lakukan iuran sebelum tanggal <?= $expired_date; ?></h2>    
            <br><p style="text-align: center;color: crimson;">Abaikan email ini jika sudah membayar iuran</p>        
        </div>

        <div style="text-align: center; margin: 30px 0;">
            <a href="<?= fe ?>payment/index" class="cta-button">Iuran Disini</a>
        </div>

        <div class="footer">
            <p style="margin-top: 15px;">© 2025 Serikat SINDIKASI.</p>
            <p style="margin-top: 10px;">
                Email ini dikirim secara otomatis kepada anggota baru SINDIKASI.
            </p>
        </div>
    </div>
</body>

</html>