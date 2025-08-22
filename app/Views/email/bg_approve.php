<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang di Serikat SINDIKASI</title>
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
            <h1 class="title">Selamat Datang di Serikat SINDIKASI!</h1>
        </div>

        <div class="greeting">
            <strong>Halo <?= $getData['nama_lengkap']; ?>,</strong>
        </div>

        <div class="steps-container">
            <h2 class="steps-title">Langkah Selanjutnya untuk Mengaktifkan Keanggotaan</h2>


            <div class="step">
                <div class="step-number">1</div>
                <div class="step-content">
                    <div class="step-title">Buat Password Akun</div>
                    <div class="step-description">Aktifkan akun Anda dengan membuat password yang aman untuk mengakses dashboard membership.</div>
                </div>
            </div>

            <div class="step">
                <div class="step-number">2</div>
                <div class="step-content">
                    <div class="step-title">Login ke Dashboard Membership</div>
                    <div class="step-description">Masuk ke portal anggota untuk mengakses profil, informasi keanggotaan, dan fitur lainnya.</div>
                </div>
            </div>

            <div class="step">
                <div class="step-number">3</div>
                <div class="step-content">
                    <div class="step-title">Lakukan Pembayaran Iuran Awal</div>
                    <div class="step-description">Selesaikan pembayaran iuran pertama untuk mengakses materi pendidikan dasar.</div>
                </div>
            </div>

            <div class="step">
                <div class="step-number">4</div>
                <div class="step-content">
                    <div class="step-title">Selesaikan Materi Pendidikan Dasar</div>
                    <div class="step-description">Ikuti orientasi anggota baru secara mandiri untuk memahami landasan berdirinya SINDIKASi, serta mengetahui hak dan kewajiban kamu sebagai anggota.</div>
                </div>
            </div>
        </div>

        <div style="text-align: center; margin: 30px 0;">
            <a href="<?= fe ?>set-password?accountregister=<?= $ciphertext; ?>" class="cta-button">Buat Password</a>
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