<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333333; line-height: 1.6; margin: 0; padding: 0; }
        .wrapper { background-color: #f3f4f6; padding: 30px 15px; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); }
        .header { background-color: #0073E2; color: #ffffff; padding: 25px; text-align: center; }
        .header h2 { margin: 0; font-size: 22px; font-weight: 700; letter-spacing: 0.5px; }
        .content { padding: 30px 25px; }
        .welcome-text { font-size: 16px; margin-bottom: 20px; color: #1f2937; }
        .table-info { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .table-info td { padding: 12px; border-bottom: 1px solid #f3f4f6; font-size: 14px; }
        .table-info td.label { font-weight: bold; width: 30%; color: #4b5563; }
        .table-info td.value { color: #111827; }
        .message-title { font-size: 15px; font-weight: bold; color: #374151; margin-top: 25px; margin-bottom: 10px; }
        .message-box { background-color: #f9fafb; border-left: 4px solid #0073E2; padding: 15px 20px; border-radius: 6px; font-size: 14.5px; color: #1f2937; line-height: 1.7; white-space: pre-wrap; }
        .note { font-size: 12px; color: #6b7280; margin-top: 25px; font-style: italic; background-color: #eff6ff; padding: 12px 15px; border-radius: 6px; border: 1px solid #dbeafe; }
        .footer { font-size: 11px; color: #9ca3af; text-align: center; padding: 20px; background-color: #f9fafb; border-top: 1px solid #e5e7eb; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="header">
                <h2>Pesan Hubungi Kami Baru</h2>
            </div>
            <div class="content">
                <p class="welcome-text">Halo Admin YPAC,</p>
                <p>Sebuah pesan baru telah dikirimkan melalui formulir kontak di website KUBE YPAC. Berikut detail lengkap pengirim:</p>
                
                <table class="table-info">
                    <tr>
                        <td class="label">Nama Lengkap</td>
                        <td class="value">{{ $name }}</td>
                    </tr>
                    <tr>
                        <td class="label">Alamat Email</td>
                        <td class="value"><a href="mailto:{{ $email }}" style="color: #0073E2; text-decoration: none; font-weight: 600;">{{ $email }}</a></td>
                    </tr>
                    <tr>
                        <td class="label">Topik Kerja Sama</td>
                        <td class="value"><span style="background-color: #dbeafe; color: #1e3a8a; padding: 4px 8px; border-radius: 4px; font-weight: 600; font-size: 12px;">{{ $topic }}</span></td>
                    </tr>
                    <tr>
                        <td class="label">Waktu Kirim</td>
                        <td class="value">{{ $dateStr }}</td>
                    </tr>
                </table>
                
                <div class="message-title">Pesan yang disampaikan:</div>
                <div class="message-box">{{ $messageContent }}</div>
                
                <div class="note">
                    <strong>Catatan Balasan:</strong> Anda dapat membalas email ini secara langsung (klik Balas/Reply). Email balasan akan otomatis terkirim langsung ke alamat email pengirim di atas.
                </div>
            </div>
            <div class="footer">
                <p>Email ini dikirim secara otomatis oleh Sistem POS KUBE YPAC Semarang.</p>
            </div>
        </div>
    </div>
</body>
</html>
