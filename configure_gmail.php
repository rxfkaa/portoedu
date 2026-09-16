<?php
/**
 * Helper untuk mengonfigurasi SMTP Gmail pada file .env
 * 
 * Cara pakai (dari folder project):
 *   php configure_gmail.php
 * 
 * Fitur "Lupa Password" akan mengirim link reset ke email pengguna
 * via SMTP Gmail. API key / password aplikasi dibutuhkan.
 */

$envFile = __DIR__ . '/.env';

if (!file_exists($envFile)) {
    fwrite(STDOUT, "File .env tidak ditemukan di " . __DIR__ . "\n");
    exit(1);
}

$env = file_get_contents($envFile);

function setEnvValue(&$env, string $key, string $value): void
{
    $pattern = "/^{$key}=.*$/m";
    $replacement = $key . '="' . $value . '"';

    if (preg_match($pattern, $env)) {
        $env = preg_replace($pattern, $replacement, $env);
    } else {
        $env .= "\n{$key}=\"{$value}\"\n";
    }
}

function prompt(string $message): string
{
    fwrite(STDOUT, $message);
    $input = trim(fgets(STDIN));
    return $input;
}

fwrite(STDOUT, "=============================================\n");
fwrite(STDOUT, "  Konfigurasi SMTP Gmail - PortoEdu\n");
fwrite(STDOUT, "=============================================\n\n");

fwrite(STDOUT, "Petunjuk:\n");
fwrite(STDOUT, "  1. Aktifkan 2-Step Verification pada akun Google kamu\n");
fwrite(STDOUT, "     (https://myaccount.google.com/security)\n");
fwrite(STDOUT, "  2. Buat App Password:\n");
fwrite(STDOUT, "     https://myaccount.google.com/apppasswords\n");
fwrite(STDOUT, "     (Pilih 'Other' > nama misal 'PortoEdu')\n");
fwrite(STDOUT, "  3. Salin 16 karakter App Password (bukan password biasa)\n\n");

$email = prompt('Alamat email Gmail (contoh: nama@gmail.com): ');
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    fwrite(STDOUT, "Email tidak valid.\n");
    exit(1);
}

$appPassword = prompt('App Password Gmail (16 karakter): ');
if (empty($appPassword)) {
    fwrite(STDOUT, "App Password tidak boleh kosong.\n");
    exit(1);
}

$fromName = prompt('Nama pengirim (default: Digital Student Portfolio): ');
if (empty($fromName)) {
    $fromName = 'Digital Student Portfolio';
}

setEnvValue($env, 'MAIL_MAILER', 'smtp');
setEnvValue($env, 'MAIL_HOST', 'smtp.gmail.com');
setEnvValue($env, 'MAIL_PORT', '587');
setEnvValue($env, 'MAIL_USERNAME', $email);
setEnvValue($env, 'MAIL_PASSWORD', $appPassword);
setEnvValue($env, 'MAIL_ENCRYPTION', 'tls');
setEnvValue($env, 'MAIL_FROM_ADDRESS', $email);
setEnvValue($env, 'MAIL_FROM_NAME', $fromName);

file_put_contents($envFile, $env);

fwrite(STDOUT, "\n✓ Berhasil! Konfigurasi SMTP Gmail disimpan ke .env\n");
fwrite(STDOUT, "  Sekarang jalankan: php artisan config:clear\n\n");

