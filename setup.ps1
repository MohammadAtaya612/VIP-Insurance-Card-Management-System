# VIP Insurance System - Setup Script for Windows
# Requires: PHP 8.2+, Composer, MySQL

Write-Host "=== VIP Insurance System Setup ===" -ForegroundColor Cyan

# Find PHP
$phpPaths = @(
    "php",
    "C:\laragon\bin\php\php-8.3.30-Win32-vs16-x64\php.exe",
    "C:\laragon\bin\php\php-8.3.12-Win32-vs16-x64\php.exe",
    "C:\laragon\bin\php\php-8.2.12-Win32-vs16-x64\php.exe",
    "C:\xampp\php\php.exe"
)

$php = $null
foreach ($path in $phpPaths) {
    if (Get-Command $path -ErrorAction SilentlyContinue) {
        $php = $path
        break
    }
    if (Test-Path $path) {
        $php = $path
        break
    }
}

if (-not $php) {
    Write-Host "ERROR: PHP not found. Install Laragon or XAMPP first." -ForegroundColor Red
    Write-Host "Download Laragon: https://laragon.org/download/" -ForegroundColor Yellow
    exit 1
}

Write-Host "Using PHP: $php" -ForegroundColor Green

# Install dependencies
Write-Host "`nInstalling Composer dependencies..." -ForegroundColor Cyan
& $php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
& $php composer-setup.php
& $php composer.phar install --no-interaction
Remove-Item composer-setup.php, composer.phar -ErrorAction SilentlyContinue

# Environment
if (-not (Test-Path ".env")) {
    Copy-Item ".env.example" ".env"
    Write-Host "Created .env file - please configure database settings" -ForegroundColor Yellow
}

& $php artisan key:generate

Write-Host "`nConfigure .env with your MySQL credentials, then run:" -ForegroundColor Cyan
Write-Host "  php artisan migrate --seed" -ForegroundColor White
Write-Host "  php artisan storage:link" -ForegroundColor White
Write-Host "  php artisan serve" -ForegroundColor White
Write-Host "  php artisan queue:work" -ForegroundColor White
Write-Host "`nDefault login: admin@vip.local / password" -ForegroundColor Green
