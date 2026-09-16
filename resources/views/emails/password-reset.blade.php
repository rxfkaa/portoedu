<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
            color: #334155;
        }
        .container {
            max-width: 560px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }
        .header {
            background: linear-gradient(135deg, #2563eb, #4f46e5);
            padding: 32px 40px;
            text-align: center;
            color: #ffffff;
        }
        .header h1 {
            margin: 0;
            font-size: 22px;
        }
        .body {
            padding: 32px 40px;
        }
        .body p {
            line-height: 1.7;
            margin: 0 0 16px;
        }
        .button-wrapper {
            text-align: center;
            margin: 28px 0;
        }
        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #2563eb, #4f46e5);
            color: #ffffff !important;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 15px;
        }
        .code-box {
            background: #f1f5f9;
            border: 1px dashed #94a3b8;
            border-radius: 10px;
            padding: 16px;
            font-size: 14px;
            word-break: break-all;
            margin: 20px 0;
            text-align: center;
        }
        .expiry {
            font-size: 13px;
            color: #94a3b8;
            text-align: center;
        }
        .footer {
            background: #f8fafc;
            padding: 20px 40px;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔐 Atur Ulang Password</h1>
        </div>
        <div class="body">
            <p>Halo <strong>{{ $user->name }}</strong>,</p>
            <p>Kami menerima permintaan untuk mengatur ulang password akun <strong>Digital Student Portfolio</strong> kamu dengan email:</p>
            <p style="text-align:center;font-weight:600;">{{ $user->email }}</p>
            <p>Silakan klik tombol di bawah ini untuk membuat password baru:</p>
            <div class="button-wrapper">
                <a href="{{ $resetUrl }}" class="btn">Reset Password Sekarang</a>
            </div>
            <div class="code-box">
                Atau salin link berikut:<br>
                <span style="color:#2563eb;">{{ $resetUrl }}</span>
            </div>
            <p class="expiry">⚠️ Link ini hanya berlaku selama <strong>60 menit</strong>.</p>
            <p>Jika kamu tidak meminta pengaturan ulang password, abaikan email ini.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Digital Student Portfolio. Semua hak dilindungi.
        </div>
    </div>
</body>
</html>

